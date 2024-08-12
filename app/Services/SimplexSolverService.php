<?php

namespace App\Services;

use Simplex\Func;
use Simplex\Restriction;
use Simplex\Solver;
use Simplex\Task;

class SimplexSolverService
{
    public function solve($orders, $maxWeight, $maxVolume)
    {
        // تعريف دالة الهدف
        $objective = new Func(array_map(function($order, $index) {
            return ["x{$index}" => $order['cost']];
        }, $orders, array_keys($orders)));

        // تعريف القيود
        $constraints = [
            new Restriction(array_map(function($order, $index) {
                return ["x{$index}" => $order['weight']];
            }, $orders, array_keys($orders)), Restriction::TYPE_LOE, $maxWeight),
            new Restriction(array_map(function($order, $index) {
                return ["x{$index}" => $order['volume']];
            }, $orders, array_keys($orders)), Restriction::TYPE_LOE, $maxVolume)
        ];

        // إنشاء المهمة
        $task = new Task($objective, $constraints);

        // حل المشكلة
        $solver = new Solver($task);
        $solution = $solver->getSolution();

        return $solution;
    }
}
