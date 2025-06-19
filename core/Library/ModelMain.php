<?php

namespace Core\Library;

class ModelMain
{
    public $db;
    public $validationRules = [];
    protected $table;
    protected $primaryKey = "id";

    /**
     * construct
     */
    public function __construct()
    {
        $this->db = new Database(
            $_ENV['DB_CONNECTION'],
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD']
        );

        $this->db->table($this->table);
    }

    /**
     * getById
     *
     * @param int $id 
     * @return array
     */
    public function getById($id)
    {
        if ($id == 0) {
            return [];
        } else {
            return $this->db->where("id", $id)->first();
        }
    }

    /**
     * lista
     *
     * @param string $orderby 
     * @return array
     */
    public function lista($orderby = 'descricao', $direction = "ASC")
    {   
        return $this->db->orderBy($orderby, $direction)->findAll();
    }

    /**
     * insert
     *
     * @param array $dados 
     * @return bool
     */
    public function insert($dados, $validar = true) // Adicione o parâmetro $validar
    {
        if ($validar && Validator::make($dados, $this->validationRules)) { // Adicione a condição $validar
            return 0;
        } else {
            if ($this->db->insert($dados) > 0) {
                return true;
            } else {
                return false;
            }
        } 
    }

    /**
     * update
     *
     * @param array $dados 
     * @return bool
     */
    public function update($dados)
    {
        if (Validator::make($dados, $this->validationRules)) {
            return 0; // Se a validação falhar, retorna falso.
        } else {
            // Tenta executar a atualização no banco de dados.
            $resultado = $this->db->where($this->primaryKey, $dados[$this->primaryKey])->update($dados);

            // ---- INÍCIO DA CORREÇÃO ----
            // A verificação foi alterada de '> 0' para '!== false'.
            // Isso considera a operação um sucesso mesmo que 0 linhas sejam alteradas
            // (o que acontece quando você salva sem modificar os dados).
            // A operação só será considerada uma falha se o banco retornar um erro explícito (false).
            if ($resultado !== false) {
                return true;
            } else {
                return false;
            }
            // ---- FIM DA CORREÇÃO ----
        }
    }

    /**
     * delete
     *
     * @param array $dados 
     * @return bool
     */
    public function delete($dados)
    {
        if ($this->db->where($this->primaryKey, $dados[$this->primaryKey])->delete() > 0) {
            return true;
        } else {
            return false;
        }
    }
}