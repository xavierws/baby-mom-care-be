<?php


namespace App\Actions;


class ReadCSV
{
    public static function handle(string $path)
    {
        $array = $fields = array();
        $i = 0;
        $handle = @fopen($path, "r");
        if ($handle) {
            while (($row = fgetcsv($handle, 4096)) !== false) {
                if (empty($fields)) {
                    $fields = $row;
                    continue;
                }
                foreach ($row as $k=>$value) {
                    $array[$i][$fields[$k]] = $value;
                }
                $i++;
            }
            if (!feof($handle)) {
                echo "Error: unexpected fgets() fail\n";
            }
            fclose($handle);
        }

        return $array;
    }
}
