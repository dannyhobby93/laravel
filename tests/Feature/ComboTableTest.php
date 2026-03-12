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

test('GET /api/combo-table returns all records', function () {
    ComboTable::factory()->count(3)->create();

    $this->getJson('/api/combo-table')->assertOk()->assertJsonCount(3);
});

test('POST /api/combo-table creates a record with auto uuid', function () {
    $response = $this->postJson('/api/combo-table', ['name' => 'Alice']);

    $response->assertCreated()
        ->assertJsonStructure(['id', 'uuid', 'name'])
        ->assertJsonPath('name', 'Alice');

    expect($response->json('uuid'))->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/');
});

test('GET /api/combo-table/{uuid} returns a single record', function () {
    $record = ComboTable::factory()->create();

    $this->getJson("/api/combo-table/{$record->uuid}")
        ->assertOk()
        ->assertJsonPath('id', $record->id);
});

test('PUT /api/combo-table/{uuid} updates a record', function () {
    $record = ComboTable::factory()->create();

    $this->putJson("/api/combo-table/{$record->uuid}", ['name' => 'Updated'])
        ->assertOk()
        ->assertJsonPath('name', 'Updated');
});

test('DELETE /api/combo-table/{uuid} deletes a record', function () {
    $record = ComboTable::factory()->create();

    $this->deleteJson("/api/combo-table/{$record->uuid}")->assertNoContent();

    expect(ComboTable::count())->toBe(0);
});
