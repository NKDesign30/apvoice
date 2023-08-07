<?php 

namespace apo\migration\utilities;

trait Mapper
{    
    protected function mapSpecialKey($key, $value = null)
    {
        switch ($key) {
            case 'primary_blog':
                return get_current_blog_id();
            
            case 'age':
                return $this->mapAge($value);

            case 'form_of_address':
                return $this->mapFormOfAddress($value);

            case 'login_dates':
                return !empty($value) ? maybe_serialize([strtotime($value)]) : null;

            case 'job':
                return $this->mapJob($value);

            case 'priorities':
                return $this->mapPriorities($value);

            case 'tasks':
                return $this->mapTasks($value);

            default:
                return null;
        }
    }

    protected function mapAge($age)
    {
        switch (trim($age)) {
            case 'unter 24 J.':
                return '< 24';
                break;
            
            case '25 bis 34 J.':
                return '25 - 34';
            break;

            case '35 bis 44 J.':
                return '35 - 44';
            break;

            case '45 bis 54 J.':
                return '45 - 54';
            break;

            case '55 bis 64 J.':
                return '55 - 64';
            break;

            case '65 J. oder älter':
                return '65 +';
            break;

            default:
                return null;
                break;
        }
    }

    protected function mapCountry($country)
    {
        switch (trim($country)) {
            case 'Deutschland':
                return 'germany';
                break;
            
            case 'Österreich':
                return 'austria';
            break;

            default:
                return 'germany';
                break;
        }
    }

    protected function mapFormOfAddress($formOfAddress)
    {
        switch (trim($formOfAddress)) {
            case 'Frau':
                return 'mrs';
                break;
            
            case 'Herr':
                return 'mr';
            break;

            default:
                return $formOfAddress;
                break;
        }
    }

    protected function mapJob($job)
    {
        switch (trim($job)) {
            case 'Apotheker/-in (Inhaber/-in)':
                return 'pharmacist';
                break;
            
            case 'Apotheker/-in (angestellt)':
                return 'pharmacist_assistant';
                break;

            case 'Pharmazie - Ingenieur/in':
                return 'pharmaceutical_engineer';
                break;

            case 'PTA':
                return 'pharmacy_assistant_or_technician';
                break;

            case 'PKA (Deutschland)':
                return 'pharmaceutical_commercial_employee';
                break;

            case 'PKA (Österreich)':
                return 'pharmaceutical_commercial_employee';
                break;

            case 'PTA-Schüler/-in':
                return 'student_pharmaceutical_technician';
                break;

            case 'Choice 1':
                return 'pharmacist';
                break;

            case 'Choice 2':
                return 'pharmacist_assistant';
                break;

            default:
                return null;
                break;
        }
    }

    protected function mapPriorities($priorities)
    {
        $mappedPriorities = [];
        
        foreach ( maybe_unserialize($priorities)  as $value) {

            switch (trim($value)) {
                case 'Beratung von Kunden':
                    $value = 'consulting';
                    break;
            
                case 'Einkauf von Arzneimitteln und Medizinprodukten':
                    $value = 'purchasing';
                    break;

                case 'Warengruppenmanagement':
                    $value = 'productmanagement';
                    break;
            }

            $mappedPriorities[] = $value;
        }
         return $mappedPriorities;
    }

    protected function mapTasks($tasks)
    {
        $mappedTasks = [];
        
        foreach ( maybe_unserialize($tasks)  as $value) {

            switch (trim($value)) {
                case 'Kein Schwerpunkt':
                    $value = 'none';
                    break;
            
                case 'Einkauf':
                    $value = 'purchasing';
                    break;

                case 'Ernährung':
                    $value = 'nutrition';
                    break;

                case 'Homöopathie und Naturheilverfahren':
                    $value = 'homeopathy';
                    break;

                case 'Schmerz':
                    $value = 'pain';
                    break;

                case 'Senioren':
                    $value = 'elderly_people';
                    break;

                case 'Mutter & Kind':
                    $value = 'mother_and_child';
                    break;

                case 'Vitamine':
                    $value = 'vitamins';
                    break;

                default:
                    return null;
                    break;
            }

            $mappedTasks[] = $value;
        }
         return $mappedTasks;
    }
}