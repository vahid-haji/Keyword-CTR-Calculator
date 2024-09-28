<?php
require 'vendor/autoload.php'; // Load PHPSpreadsheet

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    // Check if a file has been uploaded
    if (isset($_FILES['file'])) {
        $fileName = $_FILES['file']['tmp_name'];

        // Load the Excel file
        $spreadsheet = IOFactory::load($fileName);
        $worksheet = $spreadsheet->getActiveSheet();

        // Get highest row number in the worksheet
        $highestRow = $worksheet->getHighestRow();

        // CTR percentages for ranks 1 to 4
        $ctr_rank1 = 0.398;
        $ctr_rank2 = 0.187;
        $ctr_rank3 = 0.102;
        $ctr_rank4 = 0.072;

        // Conversion rates
        $conversion_rate_2 = 0.02;
        $conversion_rate_5 = 0.05;

        echo "<h2>Results</h2>";
        echo "<table border='1' cellpadding='10'>
                <tr>
                    <th>Keyword</th>
                    <th>Monthly Searches</th>
                    <th>Clicks Rank 1</th>
                    <th>Conversions Rank 1 (2%)</th>
                    <th>Conversions Rank 1 (5%)</th>
                    <th>Clicks Rank 2</th>
                    <th>Conversions Rank 2 (2%)</th>
                    <th>Conversions Rank 2 (5%)</th>
                    <th>Clicks Rank 3</th>
                    <th>Conversions Rank 3 (2%)</th>
                    <th>Conversions Rank 3 (5%)</th>
                    <th>Clicks Rank 4</th>
                    <th>Conversions Rank 4 (2%)</th>
                    <th>Conversions Rank 4 (5%)</th>
                </tr>";

        // Loop through each row in the Excel sheet
        for ($row = 2; $row <= $highestRow; $row++) {
            $keyword = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
            $monthly_searches = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

            // Calculate clicks for each rank
            $clicks_rank1 = $monthly_searches * $ctr_rank1;
            $clicks_rank2 = $monthly_searches * $ctr_rank2;
            $clicks_rank3 = $monthly_searches * $ctr_rank3;
            $clicks_rank4 = $monthly_searches * $ctr_rank4;

            // Calculate conversions for each rank at 2% and 5% rates
            $conversions_rank1_2 = $clicks_rank1 * $conversion_rate_2;
            $conversions_rank1_5 = $clicks_rank1 * $conversion_rate_5;

            $conversions_rank2_2 = $clicks_rank2 * $conversion_rate_2;
            $conversions_rank2_5 = $clicks_rank2 * $conversion_rate_5;

            $conversions_rank3_2 = $clicks_rank3 * $conversion_rate_2;
            $conversions_rank3_5 = $clicks_rank3 * $conversion_rate_5;

            $conversions_rank4_2 = $clicks_rank4 * $conversion_rate_2;
            $conversions_rank4_5 = $clicks_rank4 * $conversion_rate_5;

            // Display the result in a table
            echo "<tr>
                    <td>$keyword</td>
                    <td>$monthly_searches</td>
                    <td>$clicks_rank1</td>
                    <td>$conversions_rank1_2</td>
                    <td>$conversions_rank1_5</td>
                    <td>$clicks_rank2</td>
                    <td>$conversions_rank2_2</td>
                    <td>$conversions_rank2_5</td>
                    <td>$clicks_rank3</td>
                    <td>$conversions_rank3_2</td>
                    <td>$conversions_rank3_5</td>
                    <td>$clicks_rank4</td>
                    <td>$conversions_rank4_2</td>
                    <td>$conversions_rank4_5</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "Please upload an Excel file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Excel File</title>
</head>
<body>
    <h2>Upload Excel File</h2>
    <form method="post" enctype="multipart/form-data">
        <label for="file">Select Excel file:</label>
        <input type="file" name="file" accept=".xlsx, .xls" required><br><br>
        <input type="submit" name="submit" value="Upload and Calculate">
    </form>
</body>
</html>
