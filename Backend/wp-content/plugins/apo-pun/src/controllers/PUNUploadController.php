<?php

namespace apo\pun\controllers;

use apo\pun\models\PUN;
use apo\pun\roles\PUNManagerRole;
use apo\pun\parsers\ParserFactory;
use awsm\wp\libraries\utilities\UploadUtils;
use awsm\wp\libraries\utilities\RedirectBack;

class PUNUploadController
{

    use UploadUtils, RedirectBack;

    /**
     * The uploaded file name from the input field
     */
    protected $file = 'apo_pun_codes_file';

    /**
     * PUNUploadController constructor.
     */
    public function __construct()
    {
        $this->pun = new PUN();
    }

    /**
     * Handle an incoming POST request.
     */
    public function update()
    {
        if (!current_user_can(PUNManagerRole::MANAGE_CAPABILITY)) {
            $this->redirectBack(['errors' => [__('Your user role have not the necessary capability for this action', 'apo-pun')]]);
        }

        if (!$this->hasValidNonce()) {
            $this->redirectBack(['errors' => [__('Invalid nonce. Try re-submitting the form.', 'apo-pun')]]);
        }

        header('Content-Type: text/plain');

        $values = $this->parseUploadedFile();

        if (count($values) === 0) {
            $this->redirectBack(['infos' => [__('No new PUN\'s codes have been imported. Everything is up to date.', 'apo-pun')]]);
        }

        $countUpdated = 0;
        $countAdded = 0;
        foreach ($values as $item) {
            if ($pun = $this->pun->exists($item['pharmacy_unique_number'])) {
                if ($this->pun->hasNameChanged($pun->id, $item['name'])) {
                    $this->pun->update(['name' => $item['name']], ['id' => $pun->id]);
                    $countUpdated++;
                }
            } else {
                // Stellen Sie sicher, dass die role_id aus der CSV vorhanden ist und nicht leer ist
                if (isset($item['role_id']) && $item['role_id'] !== null) {
                    // Nur dann hinzufügen/aktualisieren, wenn die role_id gültig ist (d.h. größer als 0)
                    if ($item['role_id'] > 0) {
                        $this->pun->create([
                            'pharmacy_unique_number' => $item['pharmacy_unique_number'],
                            'name' => $item['name'],
                            'role_id' => $item['role_id']  // Hier setzen wir die role_id
                        ]);
                        error_log('Inserted role_id into database: ' . $item['role_id']);  // Debug-Ausgabe
                        $countAdded++;
                    }
                }
            }
        }

        $messages = [];

        if ($countAdded > 0) {
            $messages = ['infos' => [__(sprintf('%d new PUN\'s have been added.', $countAdded), 'apo-pun')]];
        }

        if ($countUpdated > 0) {
            $messages = array_merge($messages, ['infos' => [__(sprintf('%d PUN\'s have been updated.', $countUpdated), 'apo-pun')]]);
        }

        if (count($messages) > 0) {
            $this->redirectBack($messages);
        }

        $this->redirectBack(['infos' => [__('No new PUN\'s have been imported. Everything is up to date.', 'apo-pun')]]);
    }

    /**
     * Check if the request has a valid nonce.
     *
     * @return bool
     */
    protected function hasValidNonce()
    {
        $nonce = $_POST['apo_pun_save_settings_nonce'] ?? false;

        return wp_verify_nonce(wp_unslash($nonce), 'apo_pun_save_settings');
    }

    /**
     * Parse the uploaded file from the request.
     *
     * @return array
     */
    protected function parseUploadedFile()
    {
        return ParserFactory::makeFromUpload($_FILES[$this->file])->parse();
    }
}
