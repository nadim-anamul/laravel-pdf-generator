<?php

namespace App\Traits;

trait BengaliDateTrait
{
    /**
     * Convert English date to Bengali date format (day/month/year)
     */
    public function convertToBengaliDate($englishDate)
    {
        if (!$englishDate) {
            return null;
        }

        // If the date is already in Bengali format, return it as-is
        if (preg_match('/^[০-৯]+\/[০-৯]+\/[০-৯]+$/', $englishDate)) {
            return $englishDate;
        }

        // If the date contains Bengali numerals but is in Y-m-d format, convert numerals first
        if (preg_match('/[০-৯]/u', $englishDate)) {
            $englishDate = $this->enDigits($englishDate);
        }

        try {
            $date = \Carbon\Carbon::parse($englishDate);
            
            // Convert day, month, year to Bengali numerals with proper padding
            $day = $this->convertToBengaliNumerals(str_pad($date->day, 2, '0', STR_PAD_LEFT));
            $month = $this->convertToBengaliNumerals(str_pad($date->month, 2, '0', STR_PAD_LEFT));
            $year = $this->convertToBengaliNumerals($date->year);
            
            return $day . '/' . $month . '/' . $year;
        } catch (\Exception $e) {
            // If parsing fails, return the original value
            return $englishDate;
        }
    }

    /**
     * Convert English numerals to Bengali numerals (internal)
     */
    private function convertToBengaliNumerals($number)
    {
        $englishNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        return str_replace($englishNumerals, $bengaliNumerals, (string)$number);
    }





    /**
     * Public helper: Convert any string or number's digits to Bengali.
     * If the data already contains Bengali digits, it will be returned as-is.
     */
    public function bnDigits($value)
    {
        // If already contains Bengali digits, return as-is
        if (preg_match('/[০-৯]/u', (string)$value)) {
            return (string)$value;
        }
        return $this->convertToBengaliNumerals((string)$value);
    }

    /**
     * Format a money amount using Bengali digits and fraction as "/xx"
     * Example: 287734.59 -> ২,৮৭,৭৩৪/৫৯
     */
    public function formatAmountBangla($amount): string
    {
        $formatted = number_format((float)$amount, 2, '.', ',');
        $formatted = str_replace('.', '/', $formatted);
        return $this->convertToBengaliNumerals($formatted);
    }

    /**
     * Convert amount to Bengali words (Taka and Poisha, no trailing "মাত্র")
     * Example: 287734.59 -> "দুই লক্ষ সাতাশি হাজার সাতশত চৌত্রিশ টাকা ঊনষাট পয়সা"
     */
    public function amountToBengaliWords($amount): string
    {
        $integerPart = (int) floor((float)$amount);
        $fractionPart = (int) round(((float)$amount - $integerPart) * 100);

        $takaWords = $this->toBanglaWordsInt($integerPart);
        $result = $takaWords . ' টাকা';

        if ($fractionPart > 0) {
            $paisaWords = $this->toBanglaWordsInt($fractionPart);
            $result .= ' ' . $paisaWords . ' পয়সা';
        }

        return $result;
    }

    /**
     * Convert an integer (0..999999999) to Bengali words using crore/lakh system
     */
    private function toBanglaWordsInt(int $number): string
    {
        if ($number === 0) {
            return 'শূন্য';
        }

        // Full 0..99 mapping for natural Bengali phrasing
        $map0To99 = [
            0=>'শূন্য',1=>'এক',2=>'দুই',3=>'তিন',4=>'চার',5=>'পাঁচ',6=>'ছয়',7=>'সাত',8=>'আট',9=>'নয়',
            10=>'দশ',11=>'এগারো',12=>'বারো',13=>'তেরো',14=>'চৌদ্দ',15=>'পনেরো',16=>'ষোল',17=>'সতেরো',18=>'আঠারো',19=>'উনিশ',
            20=>'বিশ',21=>'একুশ',22=>'বাইশ',23=>'তেইশ',24=>'চব্বিশ',25=>'পঁচিশ',26=>'ছাব্বিশ',27=>'সাতাশ',28=>'আটাশ',29=>'উনত্রিশ',
            30=>'ত্রিশ',31=>'একত্রিশ',32=>'বত্রিশ',33=>'তেত্রিশ',34=>'চৌত্রিশ',35=>'পঁয়ত্রিশ',36=>'ছত্রিশ',37=>'সাঁইত্রিশ',38=>'আটত্রিশ',39=>'উনচল্লিশ',
            40=>'চল্লিশ',41=>'একচল্লিশ',42=>'বিয়াল্লিশ',43=>'তেতাল্লিশ',44=>'চুয়াল্লিশ',45=>'পঁয়তাল্লিশ',46=>'ছেচল্লিশ',47=>'সাতচল্লিশ',48=>'আটচল্লিশ',49=>'উনপঞ্চাশ',
            50=>'পঞ্চাশ',51=>'একান্ন',52=>'বাহান্ন',53=>'তেপ্পান্ন',54=>'চুয়ান্ন',55=>'পঞ্চান্ন',56=>'ছাপ্পান্ন',57=>'সাতান্ন',58=>'আটান্ন',59=>'উনষাট',
            60=>'ষাট',61=>'একষট্টি',62=>'বাষট্টি',63=>'তেষট্টি',64=>'চৌষট্টি',65=>'পঁয়ষট্টি',66=>'ছেষট্টি',67=>'সাতষট্টি',68=>'আটষট্টি',69=>'উনসত্তর',
            70=>'সত্তর',71=>'একাত্তর',72=>'বাহাত্তর',73=>'তেহাত্তর',74=>'চুয়াত্তর',75=>'পঁচাত্তর',76=>'ছিয়াত্তর',77=>'সাতাত্তর',78=>'আটাত্তর',79=>'উনাশি',
            80=>'আশি',81=>'একাশি',82=>'বিরাশি',83=>'তিরাশি',84=>'চুরাশি',85=>'পঁচাশি',86=>'ছিয়াশি',87=>'সাতাশি',88=>'আটাশি',89=>'উননব্বই',
            90=>'নব্বই',91=>'একানব্বই',92=>'বিরানব্বই',93=>'তিরানব্বই',94=>'চুরানব্বই',95=>'পঁচানব্বই',96=>'ছিয়ানব্বই',97=>'সাতানব্বই',98=>'আটানব্বই',99=>'নিরানব্বই',
        ];

        $parts = [];
        $crore = intdiv($number, 10000000);
        $number %= 10000000;
        $lakh = intdiv($number, 100000);
        $number %= 100000;
        $thousand = intdiv($number, 1000);
        $number %= 1000;
        $hundred = intdiv($number, 100);
        $remainder = $number % 100;

        if ($crore > 0) {
            $parts[] = $this->toBanglaWordsInt($crore) . ' কোটি';
        }
        if ($lakh > 0) {
            $parts[] = $this->toBanglaWordsInt($lakh) . ' লক্ষ';
        }
        if ($thousand > 0) {
            $parts[] = $this->toBanglaWordsInt($thousand) . ' হাজার';
        }
        if ($hundred > 0) {
            if ($hundred === 1) {
                $parts[] = 'একশত';
            } else {
                $parts[] = $map0To99[$hundred] . 'শত';
            }
        }
        if ($remainder > 0) {
            $parts[] = $map0To99[$remainder];
        }

        return implode(' ', $parts);
    }

    /**
     * Convert Bengali date format back to English date for database storage
     */
    public function convertFromBengaliDate($date)
    {
        if (!$date) {
            return null;
        }

        // If the date is already in Y-m-d format (English), return it as is
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return $date;
        }

        // Convert Bengali numerals to English numerals
        $bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $englishNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        
        $englishDate = str_replace($bengaliNumerals, $englishNumerals, $date);
        
        // Parse the date format (day/month/year)
        $parts = explode('/', $englishDate);
        if (count($parts) === 3) {
            $day = $parts[0];
            $month = $parts[1];
            $year = $parts[2];
            
            // Validate and create date
            if (checkdate($month, $day, $year)) {
                return \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
            }
        }
        
        return null;
    }

    /**
     * Convert Bengali numerals to English numerals (internal)
     */
    private function convertToEnglishNumerals($number)
    {
        $bengaliNumerals = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $englishNumerals = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($bengaliNumerals, $englishNumerals, (string)$number);
    }

    /**
     * Public helper: Convert Bengali numerals to English numerals
     */
    public function enDigits($value)
    {
        return $this->convertToEnglishNumerals((string)$value);
    }

    /**
     * Process date fields in the request data
     */
    public function processBengaliDates($data)
    {
        $dateFields = [
            'case_date',
            'ownership_details.deed_transfers.*.deed_date',
            'ownership_details.inheritance_records.*.death_date',
            'ownership_details.applicant_info.kharij_date',
            'order_signature_date'
        ];

        foreach ($dateFields as $field) {
            if (str_contains($field, '*')) {
                // Handle array fields with wildcards
                $this->processArrayDateFields($data, $field);
            } else {
                // Handle single date fields or nested fields
                $this->processSingleDateField($data, $field);
            }
        }

        return $data;
    }

    /**
     * Process a single date field (including nested fields)
     */
    private function processSingleDateField(&$data, $fieldPath)
    {
        $parts = explode('.', $fieldPath);
        $fieldName = array_pop($parts);
        
        $current = &$data;
        foreach ($parts as $part) {
            if (!isset($current[$part])) {
                return;
            }
            $current = &$current[$part];
        }
        
        if (isset($current[$fieldName]) && $current[$fieldName]) {
            $current[$fieldName] = $this->convertFromBengaliDate($current[$fieldName]);
        }
    }

    /**
     * Process date fields in array structures
     */
    private function processArrayDateFields(&$data, $fieldPattern)
    {
        $parts = explode('.', $fieldPattern);
        $fieldName = array_pop($parts);
        
        $current = &$data;
        foreach ($parts as $part) {
            if ($part === '*') {
                // Handle wildcard for arrays
                if (is_array($current)) {
                    foreach ($current as &$item) {
                        if (isset($item[$fieldName]) && $item[$fieldName]) {
                            $item[$fieldName] = $this->convertFromBengaliDate($item[$fieldName]);
                        }
                    }
                }
                return;
            }
            
            if (!isset($current[$part])) {
                return;
            }
            
            $current = &$current[$part];
        }
        
        if (isset($current[$fieldName]) && $current[$fieldName]) {
            $current[$fieldName] = $this->convertFromBengaliDate($current[$fieldName]);
        }
    }
} 