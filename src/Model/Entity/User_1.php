<?php

namespace App\Model\Entity;

use Authentication\PasswordHasher\LegacyPasswordHasher; // Add this line
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class User extends Entity {

    // Code from bake.
    // Add this method
    protected function _setPassword(string $password): ?string {
        if (strlen($password) > 0) {
            return (new LegacyPasswordHasher())->hash($password);
        }
    }

//    public function validationDefault(Validator $validator) {
//        $validator
////                ->notEmptyString('username')
//                ->requirePresence('username', 'create')
//                ->notEmptyString('username')
//                ->add('username', 'notUrl', [
//                    'rule' => 'notUrl',
//                    'provider' => 'table',
//                    'message' => 'Enter proper username'
//                        ]
//        );
//
//        //  $validator->notEmptyString('password');
//    //    $validator->add('email', 'valid-email', ['rule' => 'email']);
//
//
//        return $validator;
//    }
//
//    public function validationHardened(Validator $validator): Validator {
//        $validator = $this->validationDefault($validator);
//
//        $validator->add('password', 'length', ['rule' => ['lengthBetween', 8, 100]]);
//        return $validator;
//    }
//
//    public function builRules(RulesChecker $rules) {
//        $rules->add($rules->existsIn('user_id', 'User'));
//        return $rules;
//    }
//
//    public function notUrl($value, array $context) {
//        return !(\Cake\Validation\Validation::url($value));
//    }

}
