<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $permissions = [

      'الاقسام',
      'تخزين قسم',
      'اضافة قسم',
      'تحديث قسم',
      'تعديل قسم',
      'حذف قسم',

      'المنتجات',
      'اضافة منتج',
      'تخزين منتج',
      'تعديل منتج',
      'تحديث منتج',
      'حذف منتج',

      'قائمة الفواتير',
      'الفواتير المدفوعة',
      'الفواتير الغير مدفوعة',
      'الفواتير المدفوعة جزئيا',
      'الفواتير المؤرشفة',
      'حالة الفاتورة',
      'تحديث حالة الدفع',
      'اضافة فاتورة',
      'تخزين فاتورة',
      'تعديل فاتورة',
      'تحديث فاتورة',
      'حذف فاتورة',
      'الغاء ارشفة الفاتورة',

      'تقارير العملاء',
      'تقارير الفواتير',

      'صلاحيات المستخدمين',
      'وظائف المستخدمين',
      'قائمة المستخدمين',


    ];

    foreach ($permissions as $permission) {
      Permission::create(['name' => $permission]);
    }
  }
}
