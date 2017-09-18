<?php

namespace common\models;

use common\models\behaviors\AuthItemBehavior;
use common\models\components\LookupTrait;
use common\models\query\AuthItemQuery;
use yii\behaviors\TimestampBehavior;
use yii\rbac\Item;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $status
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at

 * @property AuthAssignment[] $authAssignments
 * @property User[] $users
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $parentLinks
 * @property AuthItemChild[] $childLinks
 * @property AuthItem[] $parents
 * @property AuthItem[] $children
 *
 * @property array $permissions
 * @property array $roles
 */
class AuthItem extends AbstractModel
{
    use LookupTrait;

    const STATUS_ACTIVE = 'active';

    const STATUS_HIDDEN = 'hidden';

    const STATUS_SYSTEM = 'system';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuthItemBehavior::class,
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'default', 'value' => Item::TYPE_ROLE],
            [['name', 'type', 'description'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'status'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['data'], 'safe'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::class, 'targetAttribute' => ['rule_name' => 'name']],

            // Behavior
            [['permissions', 'roles'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => __('Code'),
            'type' => __('Type'),
            'description' => __('Name'),
            'rule_name' => __('Rule name'),
            'status' => __('Status'),
            'data' => __('Data'),
            'created_at' => __('Created at'),
            'updated_at' => __('Updated at'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('auth_assignment', ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::class, ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParentLinks()
    {
        return $this->hasMany(AuthItemChild::class, ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildLinks()
    {
        return $this->hasMany(AuthItemChild::class, ['parent' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParents()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }


    /**
     * @inheritdoc
     * @return AuthItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AuthItemQuery(get_called_class());
    }


    /**
     * Extra logic
     */

    public function canDelete()
    {
        return $this->status != self::STATUS_SYSTEM;
    }


    /**
     * Links
     */

    public function getPermissions()
    {
        return AuthItemChild::find()->getLinkItemNames($this->name, false, Item::TYPE_PERMISSION);
    }

    public function getPermissionsRecursive()
    {
        return AuthItemChild::find()->getLinkItemNames($this->name, true, Item::TYPE_PERMISSION);
    }

    public function getPermissionsInheritedRecursive()
    {
        $data = [];
        foreach ($this->getRoles() as $role) {
            $data = array_merge($data, AuthItemChild::find()->getLinkItemNames($role, true, Item::TYPE_PERMISSION));
        }
        return array_unique($data);
    }

    public function getRoles()
    {
        return AuthItemChild::find()->getLinkItemNames($this->name, false, Item::TYPE_ROLE);
    }

    public function getRolesRecursive()
    {
        return AuthItemChild::find()->getLinkItemNames($this->name, true, Item::TYPE_ROLE);
    }

    public function getRolesInheritedRecursive()
    {
        $data = [];
        foreach ($this->getRoles() as $role) {
            $data = array_merge($data, AuthItemChild::find()->getLinkItemNames($role, true, Item::TYPE_ROLE));
        }
        return array_unique($data);
    }

    public function getParentRolesRecursive()
    {
        return AuthItemChild::find()->getLinkItemNames($this->name, true, Item::TYPE_ROLE, true);
    }

    public function getObjects($objectName)
    {
        return $this->find()->getRoleObjects()[$this->name][$objectName];
    }

    public function getObjectsRecursive($objectName)
    {
        return $this->find()->getRoleObjectsRecursive()[$this->name][$objectName];
    }

    public function getObjectsInheritedRecursive($objectName)
    {
        $data = [];
        foreach ($this->getRoles() as $role) {
            $data = array_merge($data, $this->find()->getRoleObjectsRecursive()[$role][$objectName]);
        }
        return array_unique($data);
    }

}
