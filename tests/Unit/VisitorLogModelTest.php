<?php

namespace Tests\Unit;

use App\Models\VisitorLog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitorLogModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_visitor_log_has_correct_fillable(): void
    {
        $model = new VisitorLog();
        $fillable = $model->getFillable();

        $this->assertContains('user_id', $fillable);
        $this->assertContains('ip_address', $fillable);
        $this->assertContains('city', $fillable);
        $this->assertContains('device_type', $fillable);
        $this->assertContains('visit_date', $fillable);
    }

    public function test_visit_date_is_cast_to_date(): void
    {
        $model = new VisitorLog();
        $this->assertArrayHasKey('visit_date', $model->getCasts());
    }

    public function test_visitor_log_can_be_created(): void
    {
        VisitorLog::create([
            'ip_address'  => '1.2.3.4',
            'city'        => 'Jakarta',
            'device_type' => 'desktop',
            'visit_date'  => now()->toDateString(),
        ]);

        $this->assertDatabaseHas('visitor_logs', [
            'ip_address' => '1.2.3.4',
            'city'       => 'Jakarta',
        ]);
    }

    public function test_visitor_log_user_id_is_nullable(): void
    {
        VisitorLog::create([
            'user_id'     => null,
            'ip_address'  => '5.6.7.8',
            'device_type' => 'mobile',
            'visit_date'  => now()->toDateString(),
        ]);

        $this->assertDatabaseHas('visitor_logs', [
            'ip_address' => '5.6.7.8',
            'user_id'    => null,
        ]);
    }

    public function test_visitor_log_city_is_nullable(): void
    {
        VisitorLog::create([
            'ip_address'  => '9.10.11.12',
            'city'        => null,
            'device_type' => 'desktop',
            'visit_date'  => now()->toDateString(),
        ]);

        $this->assertDatabaseHas('visitor_logs', [
            'ip_address' => '9.10.11.12',
            'city'       => null,
        ]);
    }

    public function test_device_type_accepts_mobile_and_desktop(): void
    {
        $desktop = VisitorLog::create([
            'ip_address'  => '1.1.1.1',
            'device_type' => 'desktop',
            'visit_date'  => now()->toDateString(),
        ]);

        $mobile = VisitorLog::create([
            'ip_address'  => '2.2.2.2',
            'device_type' => 'mobile',
            'visit_date'  => now()->toDateString(),
        ]);

        $this->assertEquals('desktop', $desktop->device_type);
        $this->assertEquals('mobile', $mobile->device_type);
    }
}
