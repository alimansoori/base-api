<?php
namespace Lib\Common;


class Date
{
    protected $timestamp;

    public function __construct(string $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public static function getYesterday(): string
    {
        return strtotime('-1 days');
    }

    public static function getDaysAgo(int $day) :string
    {
        return strtotime("-$day days");
    }

    public static function getBeginOfDay(string $timestamp)
    {
        return strtotime("midnight", $timestamp);
    }

    public static function getEndOfDay(string $timestamp)
    {
        return strtotime("tomorrow", $timestamp) - 1;
    }
}