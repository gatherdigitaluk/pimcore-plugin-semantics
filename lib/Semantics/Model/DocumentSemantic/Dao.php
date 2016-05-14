<?php
/**
 * Dao
 *
 * This source file is subject to the GNU General Public License version 3 (GPLv3)
 * For the full copyright and license information, please view the LICENSE.md
 * file distributed with this source code.
 *
 * @copyright  Copyright (c) 2014-2016 Gather Digital Ltd (https://www.gatherdigital.co.uk)
 * @license    https://www.gatherdigital.co.uk/license     GNU General Public License version 3 (GPLv3)
 */

namespace Semantics\Model\DocumentSemantic;

use Pimcore\Model\Dao\AbstractDao;

class Dao extends AbstractDao
{

    /**
     * @var string $tableName
     */
    protected $tableName = 'plugin_document_semantics';

    public function save()
    {

        $vars           = get_object_vars($this->model);
        $buffer         = [];
        $validColumns   = $this->getValidTableColumns($this->tableName);

        if(count($vars)) {
            foreach ($vars as $k => $v) {

                if (!in_array($k, $validColumns)) {
                    continue;
                }

                if ($k == 'id') {
                    continue;
                }

                $getter = "get" . ucfirst($k);

                if (!is_callable([$this->model, $getter])) {
                    continue;
                }

                $value = $this->model->$getter();

                if (is_bool($value)) {
                    $value = (int) $value;
                }

                $buffer[$k] = $value;
            }
        }

        if ($this->model->getId() !== null) {
            $where = ['id = ?' => $this->model->getId()];
            $result = $this->db->update($this->tableName, $buffer, $where);
            return;
        }

        $this->db->insert($this->tableName, $buffer);
        $this->model->setId($this->db->lastInsertId());

        return;
    }

    public function delete()
    {
        $this->db->delete($this->tableName, $this->db->quoteInto("id = ?", $this->model->getId()));
    }

    /**
     * @param integer $id
     * @throws \Exception
     */
    public function getById($id)
    {

        if ($id === null) {
            throw new \Exception('getById requirements not met');
        }

        $this->model->setId($id);

        $data = $this->db->fetchRow(
            "SELECT * FROM {$this->tableName} WHERE id = ?",
            [$this->model->getId()]
        );

        if (!$data["id"]) {
            throw new \Exception('No DocumentSemantic was found with the given id');
        }

        $this->assignVariablesToModel($data);
    }

    /**
     * @param integer $id
     * @throws \Exception
     */
    public function getByDocumentId($id)
    {

        if ($id === null) {
            throw new \Exception('getByDocumentId requirements not met');
        }

        $this->model->setDocumentId($id);

        $data = $this->db->fetchRow(
            "SELECT * FROM {$this->tableName} WHERE documentId = ?",
            [$this->model->getDocumentId()]
        );

        if (!$data["id"]) {
            throw new \Exception('No DocumentSemantic was found with the given document id');
        }

        $this->assignVariablesToModel($data);
    }


}