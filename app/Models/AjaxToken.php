<?php

namespace App\Models;

use CodeIgniter\Model;

class AjaxToken extends Model
{
    protected $table = 'ajax_tokens';
    protected $primaryKey = 'id';

    protected $returnType = 'object'; // array/object/entity
    protected $allowedFields = [
        'id', 'info', 'deleted_at'
    ];
    protected $useSoftDeletes = true;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // protected $validationRules    = [
    //     'username'     => 'required|alpha_numeric_space|min_length[3]',
    //     'email'        => 'required|valid_email|is_unique[users.email]',
    //     'password'     => 'required|min_length[8]',
    //     'pass_confirm' => 'required_with[password]|matches[password]'
    // ];
    // protected $validationMessages = [
    //     'email'        => [
    //         'is_unique' => 'Sorry. That email has already been taken. Please choose another.'
    //     ]
    // ];
    // protected $skipValidation     = false;

    // public function __construct()
    // {
    //     $this->dbL = new \App\Libraries\dbLib();
    //     $this->db = $this->dbL->db;
    // }

    public function testing()
    {
        return $this->find('35016c58496dcc27d721fe54e7686a4d');
    }

    public function getInfo($id)
    {
        return $this->find($id)->select('info')->info;
    }

    public function getId($params)
    {
        $result = $this->find('5f60e27c9728e4ac79d9909a176a7d2f');
        print_r($result);
        $result = $this->where('id', '5f60e27c9728e4ac79d9909a176a7d2f')->findAll();
        print_r($result);
        $results = $this->where('info', json_encode($params))->get()->getResult();
        print_r($results);
        // echo json_encode($params);
        // foreach($results as $result):
        //     // print_r($result);
        // endforeach;
        echo (string) $this->getLastQuery();
        // exit;
        return $results;
    }

    public function getDeletedId($params)
    {
        return $this->where('info', json_encode($params))->onlyDeleted()->first()->id;
    }

    public function create($id, $params)
    {
        $this->insert([
            'id' => $id,
            'info' => json_encode($params),
        ]);
        return $this->getInsertID();
    }

    public function renew($id, $new_id)
    {
        $this->update($id, [
            'id' => $new_id,
            'deleted_at' => 'NULL',
        ]);
        return $new_id;
    }

    public function remove($criteria)
    {
        $this->where($criteria)->delete();
    }

    public function destroy($criteria)
    {
        $this->useSoftDeletes = false;
        $this->where($criteria)->delete();
        $this->useSoftDeletes = true;
    }

    // find((str/array) $primary)
    // findColumn((str)$column_name)
    // findAll()
    // first()
    // withDeleted
    // onlyDeleted

    // insert(['column'=>'value'])
    // update(['column'=>'value'])
    // save(['column'=>'value'])

    // delete($id)
    // purgeDeleted() // clean soft delete

    // Query builder applies
    // asArray()
    // asObject()
}
