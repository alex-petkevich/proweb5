<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 9/25/14
 * Time: 1:22 PM
 */
use Illuminate\Database\Eloquent\Model;


class BaseModel extends Model
{

   public function getAllColumnsNames()
   {
      switch (DB::connection()->getConfig('driver')) {
         case 'pgsql':
            $query = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $this->table . "'";
            $column_name = 'column_name';
            $reverse = true;
            break;

         case 'mysql':
            $query = 'SHOW COLUMNS FROM ' . $this->table;
            $column_name = 'Field';
            $reverse = false;
            break;

         case 'sqlsrv':
            $parts = explode('.', $this->table);
            $num = (count($parts) - 1);
            $table = $parts[$num];
            $query = "SELECT column_name FROM " . DB::connection()->getConfig('database') . ".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'" . $table . "'";
            $column_name = 'column_name';
            $reverse = false;
            break;

         default:
            $error = 'Database driver not supported: ' . DB::connection()->getConfig('driver');
            throw new Exception($error);
            break;
      }

      $columns = array();

      foreach (DB::select($query) as $column) {
         $columns[] = $column->$column_name;
      }

      if ($reverse) {
         $columns = array_reverse($columns);
      }
      return $columns;
   }

   public static function getSortOptions()
   {
      return array();
   }

}