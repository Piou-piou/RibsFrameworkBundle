# RibsAdminBundle

## Introduction

RibsAdminBundle is a symfony Bundle that allow you to manager your website. With
this bundle you will be able to : 
- Create | edit | delete users
- Give access rights to users
- Create lists of access rights and put users in them
- Create | edit | delete page
- Manage pages contents with WYIWIG system
- Manage navigation
- Add module compatible with RibsAdminBundle

## Installation

WIP : this part can change in case of developpment requirments

Go in your Symfony project and install the bundle with composer.

```
composer require piou-piou/ribs-admin-bundle    
```

### Edit configuration of symfony

Edit the file app/config/config.yml, yo have to delete nothing just add parameters under
correct parts lije framework or twig.

```
framework:
    assets:
        json_manifest_path: '%kernel.project_dir%/web/build/manifest.json'
        
# Twig Configuration
twig:
    globals:
        ribsadmin_acces_right: "@ribs_admin.acess_rights"
        
# At the end of the file add this for FOSUSer
fos_user:
    db_driver: orm # other valid values are 'mongodb', 'couchdb' and 'propel'
    firewall_name: main
    user_class: Ribs\RibsAdminBundle\Entity\FosUser
    from_email:
        address: pilloud.anthony@gmail.com
        sender_name: Ribs            
```