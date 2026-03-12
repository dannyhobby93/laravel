<?php

use App\Casts\BinaryUuidCast;
use Illuminate\Database\Eloquent\Model;

beforeEach(function () {
    $this->cast = new BinaryUuidCast;
    $this->model = new class extends Model {};
});

test('get converts 16-byte binary to formatted uuid string', function () {
    $binary = hex2bin('550e8400e29b41d4a716446655440000');

    $result = $this->cast->get($this->model, 'uuid', $binary, []);

    expect($result)->toBe('550e8400-e29b-41d4-a716-446655440000');
});

test('get returns null when value is null', function () {
    $result = $this->cast->get($this->model, 'uuid', null, []);

    expect($result)->toBeNull();
});

test('set converts uuid string to 16-byte binary', function () {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';

    $result = $this->cast->set($this->model, 'uuid', $uuid, []);

    expect($result)->toBe(hex2bin('550e8400e29b41d4a716446655440000'));
    expect(strlen($result))->toBe(16);
});

test('set returns null when value is null', function () {
    $result = $this->cast->set($this->model, 'uuid', null, []);

    expect($result)->toBeNull();
});

test('round-trip set then get returns original uuid string', function () {
    $uuid = '550e8400-e29b-41d4-a716-446655440000';
    $binary = $this->cast->set($this->model, 'uuid', $uuid, []);
    $result = $this->cast->get($this->model, 'uuid', $binary, []);

    expect($result)->toBe($uuid);
});
