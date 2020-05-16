<?php
function determinant($matrix) {
    if (!is_array($matrix))
        throw new Exception('В параметрах функции должен передаваться массив');

    // убиваем ключи, для дальнейших правильных расчетов
    $matrix = array_values($matrix);

    $arCount = count($matrix);
    $determinant = 0;

    foreach ($matrix as $rowNum => $row) {
        $matrix[$rowNum] = array_values($row);

        if (count($row) != $arCount)
            throw new Exception('Матрица должна быть квадратной (2x2, 3x3 и т.д.).');

        if (!is_array($row))
            throw new Exception('В параметрах функции должен передаваться двумерный массив');

        foreach ($row as $val) {
            if (is_array($val))
                throw new Exception('В параметрах функции должен передаваться двумерный массив');

            if (!is_numeric($val)) {
                throw new Exception('Значениями массива должны быть числа');
            }
        }
    }

    // матрица 1x1
    if ($arCount == 1)
        return $matrix[0][0];
    // для матрицы 2x2 формула следующая:
    if ($arCount == 2)
        return $matrix[0][0] * $matrix[1][1] - $matrix[0][1] * $matrix[1][0];


    $sign = -1;

    $minors = $matrix[0];
    //метод наименьших миноров по первой строке
    foreach ($minors as $index => $minor) {
        $sign *= -1;

        // делаем массив без строки и столбца
        $subArray = $matrix;
        unset($subArray[0]); // удаляем строку
        foreach ($subArray as $rowNum => $val) //удаляем столбец
            unset($subArray[$rowNum][$index]);

        $newMatrix = determinant($subArray);
        $determinant += $sign*$minor*$newMatrix;
    }

    return $determinant;
}
/*
 * Массивы для проверки
 */
$ar1x1 = array(
    array(5));

$ar2x2 = array(
    0=> array(11, 12),
    100=>array(21, 22)); // определитель 0

$ar3x3 = array(
    array(11, 12, 13),
    array(21, 22, 23),
    array(31, 32, 33)); // определитель 0

$ar4x4 = array(
    array(3, 56, -13, -5),
    array(-50, 24, -23, 10),
    array(-50, 24, -23, 11),
    array(-31, 22, -33, -6)); // определитель 48702

$ar5x5 = array(
    array(-11, 12, -13, 14, 15),
    array(21, 22, 23, 24, 25),
    array(31, -32, 33, 34, 35),
    array(41, 42, -43, 44, 45),
    array(51, 52, -53, 54, 55)); // определитель 647680

// ошибки
// неквадратная матрица
$ar4x3er = array(
    array(11, 12, 13),
    array(21, 22, 23),
    array(21, 22, 23),
    array(31, 32, 33));

// строки
$ar3x3erString = array(
    array("12", 12, 13),
    array(21, "qwe", 23),
    array(31, 32, 33));
// не массив
$notAr = 56;
// одномерный массив
$ar1x1er = array(
    5);

try {
    echo determinant($ar1x1);
} catch (Exception $e) {
    echo "Ошибка: " . $e;
}
