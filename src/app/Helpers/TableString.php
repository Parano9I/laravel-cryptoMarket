<?php

namespace App\Helpers;

class TableString
{
    private const HEADERS_COUNT = 1;
    private const COLUMN_PADDING = 1;

    private array $tableData = [];

    private array $columnsLength = [];
    private int $columnsCount;
    private int $tableWidth;

    private int $rowsCount;
    private int $tableHeight;

    public function __construct(array $headers, array $rows)
    {
        $this->tableData['header'] = $headers;
        $this->tableData['rows'] = $rows;

        $this->getColumnsLength();

        $this->columnsCount = count($this->tableData['header']);
        $this->rowsCount = count($this->tableData['rows']);

        $this->tableWidth = $this->getTableWidth();
        $this->tableHeight = $this->getTableHeight();
    }

    private function getColumnsLength()
    {
        $columns = $this->tableData['header'];

        foreach ($columns as $columnIdx => $ceil) {
            $column = $this->getColumn($columnIdx);
            $minColumnLength = $this->getMinLengthColumn($column);

            $this->columnsSize[] = $minColumnLength;
        }
    }

    private function getColumn(int $columnIdx): array
    {
        $header = $this->tableData['header'];
        $rows = $this->tableData['rows'];

        return [
            $header[$columnIdx],
            ...array_column($rows, $columnIdx)
        ];
    }

    private function getMinLengthColumn(array $column): int
    {
        $rowsLength = array_map('strlen', $column);
        $maxRowLength = max($rowsLength);

        return $maxRowLength;
    }

    private function getTableWidth()
    {
        $columnsWidth = 0;

        foreach ($this->columnsSize as $columnLength) {
            $columnWidthWithPaddings = $this->getColumnWidthWithPadding($columnLength);
            $columnsWidth += $columnWidthWithPaddings;
        }

        $widthOuterBorders = 2;
        $widthInnerBorders = $this->columnsCount - 1;
        $fullWidth = $columnsWidth + $widthOuterBorders + $widthInnerBorders;

        return $fullWidth;
    }

    public function getColumnWidthWithPadding($columnWidth)
    {
        return $columnWidth + self::COLUMN_PADDING * 2;
    }

    private function getTableHeight()
    {
        return $this->rowsCount + self::HEADERS_COUNT;
    }

    public function render()
    {
        $result = '';
        $columnSeparator = '|';

        $rows = $this->tableData['rows'];
        $header = $this->tableData['header'];

        for ($rowIdx = 0; $rowIdx < $this->rowsCount; $rowIdx++) {
            $row = $this->renderRowSeparator() . PHP_EOL;
            for ($columnIdx = 0; $columnIdx < $this->columnsCount; $columnIdx++) {
                $ceil = '';

                if ($rowIdx === 0) {
    ``                $ceil .= $header[$columnIdx];
                } else {
                    $ceil .= $rows[$rowIdx][$columnIdx];
                }

                $startPaddingSize = self::COLUMN_PADDING;

                $columnWidthWithPadding = $this->getColumnWidthWithPadding($this->columnsSize[$columnIdx]);
                $row .= $columnSeparator . ' ' . str_pad($ceil, $columnWidthWithPadding - $startPaddingSize, ' ');

                if ($columnIdx === $this->columnsCount - 1) $row .= '|';
            }
            $result .= $row . PHP_EOL;
        }

        return $result . $this->renderRowSeparator();
    }

    //+---------------+-----------------------+------------------+

    private function renderRowSeparator()
    {
        $crossChar = '+';
        $lineChar = '-';

        $result = '';

        foreach ($this->columnsSize as $idx => $columnWidth) {
            $columnWidthWithPadding = $this->getColumnWidthWithPadding($columnWidth);
            $columnPart = $crossChar . str_pad('', $columnWidthWithPadding, $lineChar);

            $result .= $columnPart;
        }

        return $result . $crossChar;
    }
}
