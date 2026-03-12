<?php

use App\Models\UuidOnly;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

test('auto-generates a uuid on creation', function () {
    $record = UuidOnly::create(['name' => 'Bob']);

    expect($record->uuid)->toBeString()
        ->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/');
});

test('uuid is stored as 16-byte binary in the database', function () {
    $record = UuidOnly::create(['name' => 'Bob']);

    $raw = DB::table('uuid_only')->first()->uuid;

    expect(strlen($raw))->toBe(16);
});

test('uuid is the primary key', function () {
    $record = UuidOnly::create(['name' => 'Bob']);

    expect($record->getKeyName())->toBe('uuid');
    expect($record->getKey())->toBe($record->uuid);
});

test('incrementing is false', function () {
    expect((new UuidOnly)->incrementing)->toBeFalse();
});

test('can update a record', function () {
    $record = UuidOnly::create(['name' => 'Bob']);
    $record->name = 'Updated';
    $record->save();

    $row = DB::table('uuid_only')->first();
    expect($row->name)->toBe('Updated');
    expect(DB::table('uuid_only')->count())->toBe(1);
});

test('can resolve route binding from string uuid', function () {
    $record = UuidOnly::create(['name' => 'Bob']);

    $found = (new UuidOnly)->resolveRouteBinding($record->uuid);

    expect($found->uuid)->toBe($record->uuid);
});

test('factory creates valid records', function () {
    $record = UuidOnly::factory()->create();

    expect($record->uuid)->toBeString();
    expect($record->name)->toBeString();
});

test('GET /api/uuid-only returns all records', function () {
    UuidOnly::factory()->count(3)->create();

    $this->getJson('/api/uuid-only')->assertOk()->assertJsonCount(3);
});

test('POST /api/uuid-only creates a record with auto uuid', function () {
    $response = $this->postJson('/api/uuid-only', ['name' => 'Bob']);

    $response->assertCreated()
        ->assertJsonStructure(['uuid', 'name'])
        ->assertJsonPath('name', 'Bob');

    expect($response->json('uuid'))->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/');
});

test('GET /api/uuid-only/{uuid} returns a single record', function () {
    $record = UuidOnly::factory()->create();

    $this->getJson("/api/uuid-only/{$record->uuid}")
        ->assertOk()
        ->assertJsonPath('uuid', $record->uuid);
});

test('PUT /api/uuid-only/{uuid} updates a record', function () {
    $record = UuidOnly::factory()->create();

    $this->putJson("/api/uuid-only/{$record->uuid}", ['name' => 'Updated'])
        ->assertOk()
        ->assertJsonPath('name', 'Updated');
});

test('DELETE /api/uuid-only/{uuid} deletes a record', function () {
    $record = UuidOnly::factory()->create();

    $this->deleteJson("/api/uuid-only/{$record->uuid}")->assertNoContent();

    expect(UuidOnly::count())->toBe(0);
});
