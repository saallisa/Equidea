<?php

namespace Equidea\Bridge\Normalizer;

/**
 * @author      Lisa Saalfrank <lisa.saalfrank@web.de>
 * @copyright   2018 Equidea
 * @package     Equidea
 * @version     0.1.0-dev
 */
class AgeNormalizer {

    /**
     * @var array
     */
    private $years = ['HORSE_AGE_YEAR', 'HORSE_AGE_YEARS'];

    /**
     * @var array
     */
    private $months = ['HORSE_AGE_MONTH', 'HORSE_AGE_MONTHS'];

    /**
     * @var array
     */
    private $weeks = ['HORSE_AGE_WEEK', 'HORSE_AGE_WEEKS'];

    /**
     * @param   int $age
     *
     * @return  array
     */
    private function calculateAge(int $age) : array
    {
        // Calculate the age in years
        $restYears = $age % 48;
        $years = ($age - $restYears) / 48;

        // Calculate the age in months
        $restMonths = $restYears % 4;
        $months = ($restYears - $restMonths) / 4;

        // Return a response array with the formated age
        return [
            'years' => $years,
            'months' => $months,
            'weeks' => $restMonths
        ];
    }

    /**
     * @param   int $age
     *
     * @return  array
     */
    public function formatAge(int $age) : array
    {
        // Format age from weeks to y-m-w
        $format = $this->calculateAge($age);

        // Get the subjects for the age
        $years = ($format['years'] === 1) ? $this->years[0] : $this->years[1];
        $months = ($format['months'] === 1) ? $this->months[0] : $this->months[1];
        $weeks = ($format['weeks'] === 1) ? $this->weeks[0] : $this->weeks[1];

        // Return an array with the age and the related subjects
        return [
            'years' => ['age' => $format['years'], 'subject' => $years],
            'months' => ['age' => $format['months'], 'subject' => $months],
            'weeks' => ['age' => $format['weeks'], 'subject' => $weeks]
        ];
    }

    /**
     * @param   array   $horses
     *
     * @return  array
     */
    public function formatMultiple(array $horses) : array
    {
        foreach ($horses as $key => $value) {
            $horses[$key]['age'] = $this->formatAge($value['age']);
        }
        return $horses;
    }
}
