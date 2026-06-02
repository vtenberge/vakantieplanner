<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BudgetItem;
use App\Models\DayItem;
use App\Models\PackingItem;
use App\Models\Place;
use App\Models\Trip;
use App\Models\TripDay;
use App\Models\TripMember;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $sara = User::create(['name' => 'Sara de Wit',   'email' => 'sara@dewit.nl',   'password' => Hash::make('password')]);
        $tom  = User::create(['name' => 'Tom Bakker',    'email' => 'tom@bakker.io',   'password' => Hash::make('password')]);
        $niki = User::create(['name' => 'Niki Janssen',  'email' => 'niki@janssen.nl', 'password' => Hash::make('password')]);
        $vera = User::create(['name' => 'Vera Smit',     'email' => 'vera.smit@me.com','password' => Hash::make('password')]);

        // ── Lissabon ─────────────────────────────────────────────────
        $lis = Trip::create([
            'owner_id' => $sara->id,
            'title'    => 'Lissabon',
            'subtitle' => 'Met de groep',
            'country'  => 'Portugal',
            'dates'    => '12 — 19 juli 2026',
            'starts_on'=> '2026-07-12',
            'ends_on'  => '2026-07-19',
            'nights'   => 7,
            'budget'   => 1240,
            'cover'    => 'linear-gradient(135deg,#a87f5e 0%,#5b3b25 60%,#241612 100%)',
            'map_lat'  => 38.7223,
            'map_lng'  => -9.1393,
            'map_zoom' => 14,
        ]);

        TripMember::insert([
            ['trip_id' => $lis->id, 'user_id' => $sara->id, 'role' => 'eigenaar', 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $lis->id, 'user_id' => $tom->id,  'role' => 'bewerker', 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $lis->id, 'user_id' => $niki->id, 'role' => 'bewerker', 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $lis->id, 'user_id' => $vera->id, 'role' => 'kijker',   'created_at' => now(), 'updated_at' => now()],
        ]);

        $days = [
            ['Zo 12 jul', 'Aankomst',      '29°', [
                ['14:20', 'Vlucht KL1693 · AMS → LIS',         'flight',  $tom->id],
                ['16:40', 'Taxi naar Alfama',                   'transit', $sara->id],
                ['19:00', 'Diner — Taberna da Rua das Flores',  'food',    $niki->id],
            ]],
            ['Ma 13 jul', 'Stad verkennen','31°', [
                ['10:00', 'Tram 28 vanaf Martim Moniz',         'transit', $sara->id],
                ['12:30', 'LX Factory — lunch & shoppen',       'place',   $vera->id],
                ['16:00', 'Castelo de São Jorge',               'place',   $tom->id],
                ['21:00', 'Fado in Bairro Alto',                'place',   $niki->id],
            ]],
            ['Di 14 jul', 'Sintra dagtrip','27°', [
                ['09:00', 'Trein naar Sintra',                  'transit', $tom->id],
                ['11:00', 'Palácio da Pena',                    'place',   $sara->id],
                ['15:00', 'Quinta da Regaleira',                'place',   $niki->id],
            ]],
            ['Wo 15 jul', 'Strand Cascais','26°', [
                ['10:30', 'Trein Cais do Sodré → Cascais',      'transit', $vera->id],
                ['12:00', 'Praia da Rainha',                    'place',   $sara->id],
                ['20:00', 'Diner Marisco na Praça',             'food',    $tom->id],
            ]],
        ];
        foreach ($days as $i => [$dateLabel, $label, $weather, $items]) {
            $day = TripDay::create([
                'trip_id'    => $lis->id,
                'day_number' => $i + 1,
                'date_label' => $dateLabel,
                'label'      => $label,
                'weather'    => $weather,
            ]);
            foreach ($items as [$time, $title, $kind, $by]) {
                DayItem::create(['trip_day_id' => $day->id, 'time' => $time, 'title' => $title, 'kind' => $kind, 'added_by' => $by]);
            }
        }

        $packing = [
            ['Paspoort',                 $sara->id, true,  'Documenten'],
            ['Reisverzekering printen',  $sara->id, true,  'Documenten'],
            ['Zonnebrand SPF 50',        $niki->id, false, 'Verzorging'],
            ['Adapter EU',               $tom->id,  false, 'Elektronica'],
            ['Zwemkleding',              $vera->id, true,  'Kleding'],
            ['Wandelschoenen',           $tom->id,  false, 'Kleding'],
            ['Kaartspel',                $niki->id, false, 'Overig'],
            ['Oplader telefoon',         $vera->id, false, 'Elektronica'],
        ];
        foreach ($packing as [$text, $userId, $done, $cat]) {
            PackingItem::create(['trip_id' => $lis->id, 'text' => $text, 'user_id' => $userId, 'done' => $done, 'category' => $cat]);
        }

        $places = [
            ['Taberna da Rua das Flores', 'Restaurant', 'Geen reservering, vroeg gaan', 3, 38.7101, -9.1401],
            ['Time Out Market',           'Markt',      'Lunch — proeven van alles',    4, 38.7068, -9.1491],
            ['Pastéis de Belém',          'Bakkerij',   'Originele pastéis',            4, 38.6979, -9.2033],
            ['Park bar Lost In',          'Bar',        'Uitzicht op de heuvels',       2, 38.7192, -9.1425],
            ['Cervejaria Ramiro',         'Restaurant', 'Schaaldieren, druk',           3, 38.7231, -9.1363],
        ];
        foreach ($places as [$name, $kind, $note, $liked, $lat, $lng]) {
            Place::create(['trip_id' => $lis->id, 'name' => $name, 'kind' => $kind, 'note' => $note, 'liked' => $liked, 'lat' => $lat, 'lng' => $lng]);
        }

        Booking::insert([
            ['trip_id' => $lis->id, 'type' => 'Vlucht heen',  'title' => 'KL1693 · AMS → LIS',       'date_label' => '12 jul · 11:55', 'booking_code' => 'X8K2P9',    'cost' => 184, 'added_by' => $tom->id,  'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $lis->id, 'type' => 'Appartement',  'title' => 'Casa Alfama (2 slaapk.)',   'date_label' => '12 — 19 jul',    'booking_code' => 'AIRB-44218', 'cost' => 720, 'added_by' => $sara->id, 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $lis->id, 'type' => 'Auto Sintra',  'title' => 'Renault Clio',              'date_label' => '14 jul · 08:00', 'booking_code' => 'EUR-91032',  'cost' => 64,  'added_by' => $niki->id, 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $lis->id, 'type' => 'Vlucht terug', 'title' => 'TP662 · LIS → AMS',        'date_label' => '19 jul · 13:10', 'booking_code' => 'Q1L7N3',     'cost' => 192, 'added_by' => $tom->id,  'created_at' => now(), 'updated_at' => now()],
        ]);

        BudgetItem::insert([
            ['trip_id' => $lis->id, 'title' => 'Appartement',          'user_id' => $sara->id, 'amount' => 720, 'split' => 'alle', 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $lis->id, 'title' => 'Vluchten heen',        'user_id' => $tom->id,  'amount' => 736, 'split' => 'alle', 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $lis->id, 'title' => 'Boodschappen aankomst','user_id' => $niki->id, 'amount' => 38,  'split' => 'alle', 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $lis->id, 'title' => 'Diner Taberna',        'user_id' => $vera->id, 'amount' => 92,  'split' => 'alle', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Texel ─────────────────────────────────────────────────────
        $txl = Trip::create([
            'owner_id' => $sara->id,
            'title'    => 'Texel — long weekend',
            'subtitle' => 'Met Tom',
            'country'  => 'Nederland',
            'dates'    => '2 — 5 oktober 2026',
            'starts_on'=> '2026-10-02',
            'ends_on'  => '2026-10-05',
            'nights'   => 3,
            'budget'   => 400,
            'cover'    => 'linear-gradient(135deg,#cfd6c7 0%,#7c8770 60%,#2f3a30 100%)',
        ]);
        TripMember::insert([
            ['trip_id' => $txl->id, 'user_id' => $sara->id, 'role' => 'eigenaar', 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $txl->id, 'user_id' => $tom->id,  'role' => 'bewerker', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ── Tokyo ─────────────────────────────────────────────────────
        $tok = Trip::create([
            'owner_id' => $sara->id,
            'title'    => 'Tokyo & Kyoto',
            'subtitle' => 'Idee — nog niet geboekt',
            'country'  => 'Japan',
            'dates'    => 'Maart 2027 · 16 dagen',
            'starts_on'=> '2027-03-01',
            'ends_on'  => '2027-03-16',
            'nights'   => 15,
            'budget'   => 3000,
            'cover'    => 'linear-gradient(135deg,#e9c5c0 0%,#8a3a3a 60%,#2a0d0d 100%)',
        ]);
        TripMember::insert([
            ['trip_id' => $tok->id, 'user_id' => $sara->id, 'role' => 'eigenaar', 'created_at' => now(), 'updated_at' => now()],
            ['trip_id' => $tok->id, 'user_id' => $niki->id, 'role' => 'bewerker', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
