<?php

use App\Models\ComboTable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('auto-generates a uuid on creation', function () {
    $record = ComboTable::create(['name' => 'Alice']);

    expect($record->uuid)->toBeString()
        ->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/');
});

test('uuid is stored as 16-byte binary in the database', function () {
    $record = ComboTable::create(['name' => 'Alice']);

    $raw = DB::table('combo_table')->where('id', $record->id)->value('uuid');

    expect(strlen($raw))->toBe(16);
});

test('uuid is unique per record', function () {
    $a = ComboTable::create(['name' => 'A']);
    $b = ComboTable::create(['name' => 'B']);

    expect($a->uuid)->not->toBe($b->uuid);
});

test('id increments independently of uuid', function () {
    $a = ComboTable::create(['name' => 'A']);
    $b = ComboTable::create(['name' => 'B']);

    expect($b->id)->toBe($a->id + 1);
});

test('can resolve route binding from string uuid', function () {
    $record = ComboTable::create(['name' => 'Alice']);

    $found = (new ComboTable)->resolveRouteBinding($record->uuid);

    expect($found->id)->toBe($record->id);
});

test('factory creates valid records', function () {
    $record = ComboTable::factory()->create();

    expect($record->uuid)->toBeString();
    expect($record->name)->toBeString();
});
