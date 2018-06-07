<?php

namespace App\Providers\Helper;


use App\Models\Piece;

class PieceValidator
{
    public function validatePieceToPosition(Piece $piece, $side, $positionTo, $existPieceTo = false)
    {
        $positionFrom = $this->flipToBottomSide($piece->position, $side);
        $positionTo = $this->flipToBottomSide($positionTo, $side);


    }

    protected function flipToBottomSide(array $position, $side)
    {
        list ($y, $x) = $position;

        switch ($side) {
            case 1:
                $x = 11 - $x;
                $y = 11 - $y;
                break;
            case 2:
                $x1 = $x;
                $x = 11 - $y;
                $y = $x1;
                break;
            case 3:
                $x1 = $x;
                $x = 11 - $y;
                $y = 11 - $x1;
                break;
            case 4:
                break;
            default:
                throw new \Exception("Unexpected side");
        }

        return [$y, $x];
    }

    /**
     * @param $positionFrom
     * @param $positionTo
     * @param $existPieceTo
     * @return bool
     */
    protected function validatePawn($positionFrom, $positionTo, $existPieceTo)
    {
        if ($positionFrom[0] === 10 && $positionFrom[1] === $positionTo[1]) {
            if ($positionFrom[0] - $positionTo[0] < 3) {
                return true;
            }
        }

        if ($positionFrom[0] - $positionTo[0] < 2) {
            if ($positionTo[1] === $positionFrom[1]) {
                return true;
            } else if ($existPieceTo && abs($positionTo[1] - $positionFrom[1]) == 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $positionFrom
     * @param $positionTo
     * @param $existPieceTo
     * @return bool
     */
    protected function validateRook($positionFrom, $positionTo, $existPieceTo)
    {
        if ($positionFrom[0] === $positionTo[0] || $positionTo[1] === $positionFrom[1]) {
            return true;
        }

        return false;
    }

    /**
     * @param $positionFrom
     * @param $positionTo
     * @param $existPieceTo
     * @return bool
     */
    protected function validateBishop($positionFrom, $positionTo, $existPieceTo)
    {
        if (abs($positionFrom[0] - $positionTo[0]) === abs($positionTo[1] - $positionFrom[1])) {
            return true;
        }

        return false;
    }

    /**
     * @param $positionFrom
     * @param $positionTo
     * @param $existPieceTo
     * @return bool
     */
    protected function validateKnight($positionFrom, $positionTo, $existPieceTo)
    {
        if (abs($positionFrom[0] - $positionTo[0]) === abs($positionTo[1] - $positionFrom[1])) {
            return true;
        }

        return false;
    }
}