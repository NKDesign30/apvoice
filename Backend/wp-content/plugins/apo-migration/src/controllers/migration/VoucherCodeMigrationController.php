<?php 

namespace apo\migration\controllers\migration;

use apo\bonago\models\Voucher;
use apo\bonago\models\VoucherUser;
use apo\migration\controllers\AbstractMigrationController;
use apo\migration\controllers\migration\UsersMigrationController;
use apo\migration\utilities\UploadTrait;

class VoucherCodeMigrationController extends AbstractMigrationController
{
    
    use UploadTrait;
    /**
     * Migration Status Identifier in table
     */
    const MIGRATION_STATUS_IDENTIFIER = 'voucher_codes_migrated';

    /**
     * Define files and directories
     */
    const FILE_PREFIX = 'vouchers_';
    const DIRECTORY = 'vouchers';
    const CREATED_VOUCHERS_FILE_PREFIX = 'vouchers_created_';

    /**
     * Defines start prefix of file
     */
    protected $createdVouchersFilePrefix = self::CREATED_VOUCHERS_FILE_PREFIX;
    protected $userIdMappingFilePrefix = UsersMigrationController::USER_ID_MAPPING_FILE_PREFIX;

    /**
     * Defines subdirectories
     */
    protected $usersDirectory = UsersMigrationController::DIRECTORY;


    /**
    * Creates a new instance of VoucherCodeMigrationController
    */
    public function __construct()
    {
        parent::__construct();
    }

    public function fetchAndWrite()
    {
        $results = [];
        foreach ($this->countries as $key => $country) {

            $vouchers = $this->migrationDB->get_results(
                "SELECT 
                    *
                FROM 
                    `mtjpt_aav_redeem`
                "
            );

            if ($key === 'at') {
                // get only assigned vouchers
                $computedVouchers = array_filter($vouchers, function($voucher) {
                    return $voucher->uid != 0;
                });
            } else {
                $computedVouchers = $vouchers;
            } 

            $this->writeFileInSubdirectory($this->directory, "{$this->filePrefix}{$key}", $computedVouchers);
            $results[$key] =  sizeof($computedVouchers) . " Voucher Codes was written in {$this->filePrefix}{$key}.json for {$country}.\n";
        }

        return $this->printResults($results);
    }

    public function create()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->filePrefix,
            $this->usersDirectory . '/' . $this->userIdMappingFilePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {

                $createdVouchers = [];
                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $voucherModel = new Voucher();
                $voucherUserModel = new VoucherUser();

                $userIdMapping = $this->readFileFromSubdirectory($this->usersDirectory, "{$this->userIdMappingFilePrefix}{$countryKey}")[0];

                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->filePrefix}{$countryKey}") as $voucher) {

                    $record = $voucherModel->create([
                        'voucher_code' => $voucher['voucher'],
                        'assigned' => $voucher['uid'] == 0 ? 0 : 1,
                        'redeemed' => $voucher['used'] == 0 ? 0 : 1,
                        'assigned_at' => null,
                        'redeemed_at' => $voucher['used'] == 0 ? null : date('Y-m-d H:i:s', $voucher['used']),
                        'created_at' => $voucher['created'] == 0 ? date('Y-m-d H:i:s', time()) : date('Y-m-d H:i:s', $voucher['created']),
                        'expires_at' => ($expiresAt = \DateTime::createFromFormat("d.m.Y", $voucher['valid_to'])) ? $expiresAt->format('Y-m-d') : null,
                    ]);

                    $createdVouchers[] = $record;

                    if($record->assigned && $userIdMapping[$voucher['uid']]) {
                        $voucherUserModel->create([
                            'voucher_code_id' => $record->id,
                            'user_id' => $userIdMapping[$voucher['uid']],
                        ]);
                    }

                    // Ready for testing
                    //if($record->assigned && !$userIdMapping[$voucher['uid']]) {
                    //    $voucherModel->removeBulk([$record->id]);
                    //array_pop($createdVouchers);
                    //}

                }

                $this->writeFileInSubdirectory($this->directory, "{$this->createdVouchersFilePrefix}{$countryKey}", array_column($createdVouchers, 'id'));

                $results[$countryKey] = "Added " . sizeof($createdVouchers) . " Voucher Codes to {$country}.\n";

                switch_to_blog(1);

            }

        }

        $this->setMigrationStatus();

        return $this->printResults($results);
    }

    public function remove()
    {
        if( !$this->requiredFilesExists([
            $this->directory . '/' . $this->createdVouchersFilePrefix,
        ])) {
            return 'Required files for this action is missing.';
        }

        $results = [];
        foreach ($this->countries as $countryKey => $country) {

            if ( $this->blogExists($countryKey) ) {

                switch_to_blog($this->countryBlogMapper[$countryKey]);

                $voucherModel = new Voucher();
                $voucherUserModel = new VoucherUser();
                $deletedResults = [];
                foreach ($this->readFileFromSubdirectory($this->directory, "{$this->createdVouchersFilePrefix}{$countryKey}") as $voucherId) {
                    $deletedResults[] = $voucherModel->db->delete($voucherModel->table, ['id' => $voucherId]);
                    $voucherUserModel->db->delete($voucherUserModel->table, ['voucher_code_id' => $voucherId]);
                }
                $onlyDeletedRecords = array_filter($deletedResults);

                $results[$countryKey] = "Removed " . sizeof($onlyDeletedRecords) . "/" . sizeof($deletedResults) . " Voucher Codes from {$country}...\n";

                switch_to_blog(1);

            }
        }

        $this->revokeMigrationStatus();
        
        return $this->printResults($results);
    }

    protected function getFilePathsFromCreateMode()
    {
        return $this->generateFilesPathsWrittenByCreateMode([
            $this->directory . '/' . $this->createdVouchersFilePrefix,
        ]);    
    }
}