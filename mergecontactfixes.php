<?php

require_once 'mergecontactfixes.civix.php';
// phpcs:disable
use CRM_Mergecontactfixes_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function mergecontactfixes_civicrm_config(&$config) {
  _mergecontactfixes_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function mergecontactfixes_civicrm_xmlMenu(&$files) {
  _mergecontactfixes_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function mergecontactfixes_civicrm_install() {
  _mergecontactfixes_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function mergecontactfixes_civicrm_postInstall() {
  _mergecontactfixes_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function mergecontactfixes_civicrm_uninstall() {
  _mergecontactfixes_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function mergecontactfixes_civicrm_enable() {
  _mergecontactfixes_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function mergecontactfixes_civicrm_disable() {
  _mergecontactfixes_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function mergecontactfixes_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _mergecontactfixes_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function mergecontactfixes_civicrm_managed(&$entities) {
  _mergecontactfixes_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function mergecontactfixes_civicrm_caseTypes(&$caseTypes) {
  _mergecontactfixes_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function mergecontactfixes_civicrm_angularModules(&$angularModules) {
  _mergecontactfixes_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function mergecontactfixes_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _mergecontactfixes_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function mergecontactfixes_civicrm_entityTypes(&$entityTypes) {
  _mergecontactfixes_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_themes().
 */
function mergecontactfixes_civicrm_themes(&$themes) {
  _mergecontactfixes_civix_civicrm_themes($themes);
}

/**
 * Implements hook_civicrm_merge().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_merge
 */
function mergecontactfixes_civicrm_merge($type, &$data, $mainId = NULL, $otherId = NULL, $tables = NULL) {
  if ($type == 'sqls') {
    $data[] = "
      UPDATE civicrm_price_field cpf
      INNER JOIN civicrm_price_set cps
        ON cps.id = cpf.price_set_id
          AND cps.name = 'default_membership_type_amount'
      SET cpf.name = {$mainId}
      WHERE cpf.name = {$otherId};
    ";

    $data[] = "
      UPDATE civicrm_contact cc
        INNER JOIN civicrm_contact cc1
          ON cc1.id = cc.employer_id
      SET cc.organization_name = cc1.organization_name
      WHERE cc.employer_id = {$mainId} AND cc1.contact_type = 'Organization';
    ";
  }
}
