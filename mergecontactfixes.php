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
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function mergecontactfixes_civicrm_install() {
  _mergecontactfixes_civix_civicrm_install();
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
