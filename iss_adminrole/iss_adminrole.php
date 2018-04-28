<?php
/*
 * Plugin Name: ISS Roles
 * Description: Create admin, board, teacher, parent and student roles on activation.
 * Version: 1.0.0
 * Author: Azra Syed
 * Text Domain: iss_adminpref
 */
class ISS_AdminRolePlugin
{
    static function uninsatall()
    {
        $admrole = get_role ( 'administrator' );
        if (null != $admrole) {
            $admrole->remove_cap ( 'iss_admin' );
            $admrole->remove_cap ( 'iss_board' );
            $admrole->remove_cap ( 'iss_secretary' );
            $admrole->remove_cap ( 'iss_test' );
        }
        if (get_role ( 'issadminrole' )) {
            remove_role ( 'issadminrole' );
        }
        if (get_role ( 'isssecretaryrole' )) {
            remove_role ( 'isssecretaryrole' );
        }
        if (get_role ( 'issboardrole' )) {
            remove_role ( 'issboardrole' );
        }
        if (get_role ( 'issparentrole' )) {
            remove_role ( 'issparentrole' );
        }
        if (get_role ( 'issteacherrole' )) {
            remove_role ( 'issteacherrole' );
        }
        if (get_role ( 'issstudentrole' )) {
            remove_role ( 'issstudentrole' );
        }
        if (get_role ( 'isstestrole' )) {
            remove_role ( 'isstestrole' );
        }
        iss_write_log ( 'administrator role capability is_admin & iss_board removed' );
        global $wp_roles;
        if (! isset ( $wp_roles )) {
            $wp_roles = new WP_Roles ();
            iss_write_log ( $wp_roles );
        }
    }
    static function addrole($roleInternalName, $roleDisplayName, $capability)
    {
        $issrole = get_role ( $roleInternalName );
        if (null == $issrole) {
            $result = add_role ( $roleInternalName, $roleDisplayName, array (
                    'read' => true,
                    'level_0' => true,
                    $capability => true
            ) );
            iss_write_log ( $result );
            if (null != $result) {
                iss_write_log ( "{$roleInternalName} role with capability {$capability} created!" );
            }
        } else {
            iss_write_log ( "{$roleInternalName} role exists" );
        }
    }
    static function addcapability($roleInternalName, $capability)
    {
        $issrole = get_role ( $roleInternalName );
        $cap = null;
        if (null != $issrole) {
            if (isset ( $issrole->capabilities [$capability] )) {
                $cap = $issrole->capabilities [$capability];
            }
            if (null == $cap) {
                $issrole->add_cap ( $capability );
                iss_write_log ( "{$roleInternalName} role, capability {$capability} is added" );
            } else {
                iss_write_log ( "{$roleInternalName} role, capability {$capability} already exists" );
            }
        } else {
            iss_write_log ( "{$roleInternalName} role does not exists" );
        }
    }
    static function install()
    {
        global $wp_roles;
        if (! isset ( $wp_roles )) {
            $wp_roles = new WP_Roles ();
        }
                
        /// Test Role 
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addrole'
        ), array (
                'isstestrole',
                'ISS Test Role',
                'iss_test'
        ) );
  
        /// Student Role 
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addrole'
        ), array (
                'issstudentrole',
                'ISS Student Role',
                'iss_student'
        ) );
      
        /// Parent Role 
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addrole'
        ), array (
                'issparentrole',
                'ISS Parent Role',
                'iss_parent'
        ) );

        /// Teacher Role 
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addrole'
        ), array (
                'issteacherrole',
                'ISS Teacher Role',
                'iss_teacher'
        ) );

        // Teacher Role is also a parent
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addcapability'
        ), array (
                'issteacherrole',
                'iss_parent'
        ) );

        /// Board Role        
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addrole'
        ), array (
                'issboardrole',
                'ISS Board Role',
                'iss_board'
        ) );
 
        /// Secretary Role 
       forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addrole'
        ), array (
                'isssecretaryrole',
                'ISS Secretary Role',
                'iss_secretary'
        ) );

        // Secretary Role is also board member
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addcapability'
        ), array (
                'isssecretaryrole',
                'iss_board'
        ) );

         // Admin Role
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addrole'
        ), array (
                'issadminrole', // internal role name
                'ISS Admin Role', // role dislay name
                'iss_admin'  // capability
        ) );

       // Admin Role is also board member & secretary
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addcapability'
        ), array (
                'issadminrole',
                'iss_board'
        ) );
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addcapability'
        ), array (
                'issadminrole',
                'iss_secretary'
        ) );

        // wordpress admnistrator has unittest, admin, secretary & board  capabilities
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addcapability'
        ), array (
                'administrator',
                'iss_admin'
        ) );
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addcapability'
        ), array (
                'administrator',
                'iss_secretary'
        ) );
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addcapability'
        ), array (
                'administrator',
                'iss_board'
        ) );
        forward_static_call_array ( array (
                'ISS_AdminRolePlugin',
                'addcapability'
        ), array (
                'administrator',
                'iss_test'
        ) );
    }
}
register_activation_hook ( __FILE__, array (
        'ISS_AdminRolePlugin',
        'install'
) );
register_deactivation_hook ( __FILE__, array (
        'ISS_AdminRolePlugin',
        'uninsatall'
) );
