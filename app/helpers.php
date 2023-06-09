<?php

use App\Models\AssetUserId;
use App\Models\Attachment;
use App\Models\Location;
use App\Models\Role;
use App\Models\StandardClause;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

if (!function_exists('getLang')) {
    function getLang($key)
    {
        $lang = __($key);

        if ($lang == $key)
            $lang = str_replace('_', '', $lang);
        return $lang;
    }
}


if (!function_exists('universalDateFormatter')) {
    function universalDateFormatter($date)
    {
        return $date ? $date->format('Y/m/d h:i:s') : '';
    }
}

if (!function_exists('getUserName')) {
    function getUserName($userId)
    {
        $user = null;
        $user_ids = \App\Models\UserAccount::where('account_id', $userId)->get();
        foreach ($user_ids as $user) {
            $user = \App\Models\User::where('id', $user->user_id)->first();
        }
        return $user;
    }
}

if (!function_exists('checkIfAssetFunctionUsed')) {
    function checkIfAssetFunctionUsed($asset_id)
    {
        $asset_ids = \App\Models\Location::where('function', $asset_id)->first();
        return $asset_ids;
    }
}

if (!function_exists('flashSession')) {
    function flashSession($message, $type = 'success')
    {
        if (Session::get('approvalRequest') == 1) {
            $message = 'Change submitted for approval';
            Session::forget('approvalRequest');
        }
        Session::flash('message', $message);
        Session::flash('alert-class', $type);
    }
}

if (!function_exists('flashSuccess')) {
    function flashSuccess($message)
    {
        flashSession($message);
    }
}
if (!function_exists('flashError')) {
    function flashError($message)
    {
        flashSession($message, 'error');
    }
}
if (!function_exists('flashInfo')) {
    function flashInfo($message)
    {
        flashSession($message, 'info');
    }
}
if (!function_exists('flashWarning')) {
    function flashWarning($message)
    {
        flashSession($message, 'warning');
    }
}
if (!function_exists('getUnit')) {
    function getUnit()
    {
        return \App\Models\Unit::all();
    }
}
if (!function_exists('getSetting')) {
    function getSetting()
    {
        return \App\Models\Settings::first();
    }
}

if (!function_exists('getUnits')) {
    function getUnits()
    {
        return \App\Models\Location::where('type', 'units')->get();
    }
}

if (!function_exists('getDevicePorts')) {
    function getDevicePorts($location_id)
    {
        return \App\Models\Port::where('location_id', $location_id)->get();
    }
}
if (!function_exists('descriptionWrapText')) {
    function descriptionWrapText($description, $width = 100, $break = "<br>\n")
    {
        return chunk_split($description, $width, "<br>");
    }
}
if (!function_exists('getComplaintCount')) {
    function getComplaintCount($complianceVersionId)
    {
        return \App\Models\ComplianceVersionItem::where('compliance_version_id', $complianceVersionId)->where('compliant', 1)->count();
    }
}
if (!function_exists('getNonComplaintCount')) {
    function getNonComplaintCount($complianceVersionId)
    {
        return \App\Models\ComplianceVersionItem::where('compliance_version_id', $complianceVersionId)->where('compliant', 2)->count();
    }
}

if (!function_exists('getUnderProcessComplaintCount')) {
    function getUnderProcessComplaintCount($complianceVersionId)
    {
        return \App\Models\ComplianceVersionItem::where('compliance_version_id', $complianceVersionId)->where('compliant', 3)->count();
    }
}
if (!function_exists('NotEvaluated')) {
    function NotEvaluated($complianceVersionId)
    {
        return \App\Models\ComplianceVersionItem::where('compliance_version_id', $complianceVersionId)->where('compliant', 4)->count();
    }
}

if (!function_exists('getSites')) {
    function getSites()
    {
        return \App\Models\Site::all();
    }
}

if (!function_exists('getSubSites')) {
    function getSubSites()
    {
        return \App\Models\Location::where('type', 'sub_site')->get();
    }
}
if (!function_exists('getStatus')) {
    /**
     * return status array
     */
    function getStatus()
    {
        return [
            '1' => 'Active',
            '0' => 'InActive',
            '2' => 'Suspended',
        ];
    }
}
if (!function_exists('hardwareLegacy')) {
    /**
     * return status array
     */
    function hardwareLegacy()
    {
        return [
            '1' => 'Active',
            '0' => 'Obsolete',
        ];
    }
}

if (!function_exists('SinglePointofFailure')) {
    /**
     * return status array
     */
    function SinglePointofFailure()
    {
        return [
            '1' => 'Yes',
            '0' => 'No',
        ];
    }
}

if (!function_exists('softwareLegacy')) {
    /**
     * return status array
     */
    function softwareLegacy()
    {
        return [
            '1' => 'Active',
            '0' => 'Obsolete',
        ];
    }
}
if (!function_exists('Criticality')) {
    /**
     * return status array
     */
    function Criticality()
    {
        return [
            '1' => 'High',
            '0' => 'Low',
            '2' => 'Medium',
        ];
    }
}
if (!function_exists('getDepartments')) {
    function getDepartments()
    {
        return \App\Models\Department::all();
    }
}

if (!function_exists('getSystemType')) {
    function getSystemType()
    {
        return \App\Models\AssetFunction::get();
    }
}


if (!function_exists('getRights')) {
    function getRights()
    {
        return \App\Models\Right::all();
    }
}

if (!function_exists('firewallAddressGroup')) {
    function firewallAddressGroup()
    {
        return \App\Models\FirewallAddressGroup::all();
    }
}
if (!function_exists('firewallIpAddress')) {
    function firewallIpAddress()
    {
        return \App\Models\FirewallIpAddress::all();
    }
}

if (!function_exists('riskAssesments')) {
    function riskAssesments()
    {
        return \App\Models\RiskAssessment::all();
    }
}
if (!function_exists('getComputerAssets')) {
    function getComputerAssets()
    {
        return DB::table('locations')->where('type', ['computer', 'lone', 'network'])->get();
    }
}
if (!function_exists('getPolicy')) {
    function getPolicy()
    {
        return \App\Models\Policy::all();
    }
}
if (!function_exists('getFirewallAssets')) {
    function getFirewallAssets()
    {
        return DB::table('network_assets')->where('function', 21)->get();
    }
}
if (!function_exists('getAssociatIds')) {
    function getAssociatIds()
    {
        return \App\Models\UserId::all();
    }
}
if (!function_exists('getSystems')) {
    function getSystems()
    {
        return \App\Models\System::all();
    }
}
if (!function_exists('getSystemAssets')) {
    function getSystemAssets($system_id)
    {
        return \App\Models\SystemAssets::where('system_id', $system_id)->get();
    }
}

if (!function_exists('getDesignations')) {
    function getDesignations()
    {
        return \App\Models\Designation::all();
    }
}
if (!function_exists('getCompanies')) {
    function getCompanies()
    {
        return \App\Models\Company::all();
    }
}
if (!function_exists('getProducts')) {
    function getProducts()
    {
        return \App\Models\Product::all();
    }
}
if (!function_exists('getServices')) {
    function getServices()
    {
        return \App\Models\Service::all();
    }
}
if (!function_exists('getReferrals')) {
    function getReferrals()
    {
        return \App\Models\Client::all();
    }
}
if (!function_exists('getBranches')) {
    function getBranches()
    {
        return \App\Models\Branch::all();
    }
}
if (!function_exists('getReferrals')) {
    function getReferrals()
    {
        return \App\Models\Client::all();
    }
}
if (!function_exists('lgUId')) {
    function lgUId(): int
    {
        return \Illuminate\Support\Facades\Auth::user()->id ?? 0;
    }
}
if (!function_exists('getGroupedPermissions')) {
    function getGroupedPermissions()
    {
        $permissions = \Spatie\Permission\Models\Permission::all();
        return $permissions->mapToGroups(function ($item, $key) {
            return [$item['group'] => $item['name']];
        });

    }
}
if (!function_exists('permissionExist')) {
    function permissionExist($name)
    {
        return \Spatie\Permission\Models\Permission::where('name', $name)->first();

    }
}

if (!function_exists('doUserHasPermission')) {
    function doUserHasPermission($name, $user = null)
    {
        $user = $user ?? \Illuminate\Support\Facades\Auth::user();
        return \Spatie\Permission\Models\Permission::where('name', $name)->first() && $user->hasPermissionTo($name);

    }
}


if (!function_exists('checkIfSuperAdmin')) {
    function checkIfSuperAdmin($user = null)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user)
            return $user->hasRole('Super Admin');

    }
}

if (!function_exists('getAllPossibleChildTablesOfParent')) {
    function getAllPossibleChildTablesOfParent()
    {
        return ['hierarcy', 'assets', 'l01_assets', 'network_assets'];
    }
}

if (!function_exists('getAllPermissions')) {
    function getAllPermissions()
    {

        return \Spatie\Permission\Models\Permission::get();
    }
}

if (!function_exists('getAllModules')) {
    function getAllModules()
    {
        return ['company', 'unit', 'site', 'subsite', 'building', 'room', 'cabinet', 'asset', 'user', 'networks_list', 'systems', 'rights', 'user_ids', 'vendors', 'installed_softwares', 'softwares', 'software_components', 'installed_patches', 'patches', 'firewall_managments', 'risks', 'risk_assessments'];
    }
}

if (!function_exists('getConfiguration')) {
    function getConfiguration($key)
    {
        return \App\Models\Configuration::where('name', $key)->first()->value ?? 0;
    }
}


if (!function_exists('getHelpSectionText')) {
    function getHelpSectionText()
    {
        $help = \App\Models\HelpSection::where(['route_name' => str_replace('\\', '', \Illuminate\Support\Facades\Route::currentRouteAction())])->first();
        if ($help)
            return $help->help_content;

        return '';
    }
}


if (!function_exists('rec_id_replacer')) {
    function rec_id_replacer($error)
    {
        return str_replace('rec id', 'id', $error);
    }
}


if (!function_exists('currentUserId')) {
    function currentUserId()
    {
        return Auth::user()->id ?? null;
    }
}

if (!function_exists('csvToArray')) {
    function csvToArray($filename = '', $delimiter = ',', $includeHeader = false)
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $rowString = implode("", $row);
                if (trim($rowString) != "") {
                    if (!$header)
                        $header = $row;
                    else {
                        if ($includeHeader)
                            $data[] = $row;
                        else
                            $data[] = array_combine($header, $row);
                    }
                }
            }
            fclose($handle);
        }

        if ($includeHeader) {
            $data[] = $header;
        }

        return ['header' => $header, 'data' => $data];
    }

}


if (!function_exists('getNotifications')) {
    function getNotifications($limited = false)
    {
        $notifications = Auth::user()->userNotifications;
        return $notifications;
    }
}


if (!function_exists('getThreeNotifications')) {
    function getThreeNotifications($limited = false)
    {
        $notifications = Auth::user()->userFirstThreeNotifications;
        return $notifications;
    }
}

if (!function_exists('formatFieldsForFrontEnd')) {
    function formatFieldsForFrontEnd($obj)
    {
        $object = new stdClass();
        if ($obj) {
            foreach ($obj as $item => $value) {

                $object->{ucwords(str_replace('_', '', $item))} = $value;
            }
        }
        return $object;
    }
}

if (!function_exists('getClauseData')) {
    function getClauseData($id)
    {
        return \App\Models\ClauseData::where('clause_id', $id)->first();

    }
}


if (!function_exists('shortClassName')) {
    function shortClassName($name)
    {
        $exp = explode('\\', $name);
        return $exp[count($exp) - 1];
    }
}

if (!function_exists('sanitizeInput')) {
    function sanitizeInput($value)
    {
        $value = preg_replace('/[^A-Za-z0-9\-_ .,()]/', '', $value);
        return utf8_encode($value);
//        return $value;
    }
}
if (!function_exists('policyValidity')) {
    function policyValidity()
    {
        return [
            '1' => 'temporary',
            '0' => 'permanent',
        ];
    }
}


if (!function_exists('assetCondition')) {
    function assetCondition($model)
    {
        $modelClass = get_class($model);
        switch ($modelClass) {
            case "App\Models\Computer":
                return "assets";
                break;
            case "App\Models\NetworkAsset":
                return "network_assets";
                break;
            case "App\Models\LoneAsset":
                return "l01_assets";
                break;
            default:
                return false;
                break;
        }
    }
}

if (!function_exists('tableColumnsMapping')) {
    function tableColumnsMapping($table, $method, $column = null)
    {
        $mappingArray = [
            'software' => [
                'vendor_name' => 'Vendor Name',
                'generalized_name' => 'Generalized Software Name',
                'long_name' => 'Unit Long Name',
                'contact_person' => 'Contact Person',
            ],
            'units' => [
                'parent_type' => 'Parent Type',
                'parent_id' => 'Parent ID',
                'rec_id' => 'Unit ID',
                'short_name' => 'Unit Name',
                'long_name' => 'Unit Long Name',
                'contact_person' => 'Contact Person',
            ],

            'sites' => [
                'parent_type' => 'Parent Type',
                'parent_id' => 'Parent ID',
                'rec_id' => 'Site ID',
                'name' => 'Site Name',
                'arabic_name' => 'Site Name(Arabic)',
                'description' => 'Site Description',
                'descriptive_location' => 'Site Location(Descriptive)',
                'location_dec_coordinate' => 'Site Location(Coordinates - Dec)',
                'location_deg_coordinate' => 'Site Location(Coordinates - Deg)',
                'location_google_link' => 'Site Location(Google Link)',
                'main_process_equipment' => 'Main Process or Equipment',
            ],
            'sub_sites' => [
                'parent_type' => 'Parent Type',
                'parent_id' => 'Parent ID',
                'rec_id' => 'SubSite ID',
                'name' => 'SubSite Name',
                'arabic_name' => 'SubSite Name(Arabic)',
                'description' => 'SubSite Description',
                'descriptive_location' => 'SubSite Location(Descriptive)',
                'location_dec_coordinate' => 'SubSite Location(Coordinates - Dec)',
                'location_deg_coordinate' => 'SubSite Location(Coordinates - Deg)',
                'location_google_link' => 'SubSite Location(Google Link)',
                'main_process_equipment' => 'Main Process or Equipment',
            ],
            'buildings' => [
                'parent_type' => 'Parent Type',
                'parent_id' => 'Parent ID',
                'rec_id' => 'Building ID',
                'name' => 'Building Name',
            ],
            'rooms' => [
                'parent_type' => 'Parent Type',
                'parent_id' => 'Parent ID',
                'rec_id' => 'Room ID',
                'name' => 'Room Name',
            ],
            'cabinets' => [
                'parent_type' => 'Parent Type',
                'parent_id' => 'Parent ID',
                'rec_id' => 'Cabinet ID',
                'name' => 'Cabinet Name',
            ],
            'computer_assets' => [
                'parent_type' => 'Parent Type',
                'parent_id' => 'Parent ID',
                'rec_id' => 'Asset ID',
                'name' => 'Asset Name',
                'description' => 'Asset Description',
                'function' => 'Asset Function',
                'make' => 'Asset Make',
                'model' => 'Asset Model',
                'part_number' => 'Asset Part Number',
                'serial_number' => 'Asset Serial Number',
                'security_zone' => 'Security Zone',
                'operating_system' => 'Operating System',
                'vm_host' => 'VM Host',
                'connected_scada_server' => 'Connected SCADA Server',
                'contact' => 'Asset Owner',
                'comment' => 'Comments',
                'single_point_of_failure' => 'Single Point of Failure',
                'criticality' => 'Criticality',
            ],
            'network_assets' => [
                'parent_type' => 'Parent Type',
                'parent_id' => 'Parent ID',
                'rec_id' => 'Asset ID',
                'name' => 'Asset Name',
                'description' => 'Asset Description',
                'function' => 'Asset Function',
                'make' => 'Asset Make',
                'model' => 'Asset Model',
                'part_number' => 'Asset Part Number',
                'serial_number' => 'Asset Serial Number',
                'security_zone' => 'Security Zone',
                'asset_firmware' => 'Asset Firmware',
                'redundant_pair_id' => 'Redundant Asset Pair ID (If Applicable)',
                'asset_contact_person' => 'Asset Owner',
                'comment' => 'Comments',
                'single_point_of_failure' => 'Single Point of Failure',
                'criticality' => 'Criticality',
            ],
            'lone_assets' => [
                'parent_type' => 'Parent Type',
                'parent_id' => 'Parent ID',
                'rec_id' => 'Asset ID',
                'name' => 'Asset Name',
                'description' => 'Asset Description',
                'function' => 'Asset Function',
                'make' => 'Asset Make',
                'model' => 'Asset Model',
                'part_number' => 'Asset Part Number',
                'serial_number' => 'Asset Serial Number',
                'security_zone' => 'Security Zone',
                'asset_firmware' => 'Asset Firmware',
                'redundant_pair_id' => 'Redundant Asset Pair ID (If Applicable)',
                'connected_scada_server' => 'Connected SCADA Server',
                'owner_contact' => 'Asset Contact Person',
                'asset_parent_code' => 'Asset Parent ID',
                'comment' => 'Comments',
                'single_point_of_failure' => 'Single Point of Failure',
                'process' => 'Process',
                'criticality' => 'Criticality',
                'parent_asset_id' => 'Asset Parent',
                'sim_ssid' => 'Sim SSID',
                'sim_imsi' => 'Sim IMSI',
                'sim_misisdn' => 'Sim MISISDN',
                'communication_type' => 'Communication Type',
                'controll' => 'Control',
                'impact_of_equipment' => 'Impact of equipment',
                'connected_site' => 'Connected to Site',
                'ot_apn' => 'OT APN',
            ],
            'standard_clauses' => [
                'standard' => 'Standard Name',
                'parent' => 'Parent',
                'number' => 'Clause Number',
                'title' => 'Clause Title',
                'description' => 'Clause Description',
                'security_control_rating' => 'Security Control Rating',
                'applicable' => 'Applicable',
                'location' => 'Applicability',
                'is_heading' => 'Heading',
            ],
            'attachments' => [
                'documentNumber' => 'Document Number',
                'version' => 'Version',
                'date' => 'Date',
                'title' => 'Title',
                'description' => 'Description',
                'category' => 'Category',
                'subCategory' => 'Sub Category',
                'file' => 'File',
            ],
            'firewall_managments' => [
                'source_zone' => 'Source Zone',
                'source_location' => 'Source Location',
                'source_asset' => 'Source Assets',
                'destination_zone' => 'Destination Zone',
                'destination_location' => 'Destination Location',
                'destination_asset' => 'Destination Assets',
                'applicatin_port' => 'Application or Port',
                'description' => 'Justification',
                'condition' => 'Policy Validity',
                'approvel_expirey_date' => 'Validity Date',
                'approved_by' => 'Approved By',
            ],
            'nozomi_data' => [
                'ip' => 'ip_address',
                'os' => 'operating_system',
                'vendor' => 'make_vendor',
            ],
            'users' => [
                'unit_id' => 'Unit ID',
                'first_name' => 'User Full Name',
                'email' => 'Email',
                'department_id' => 'Department',
                'designation_id' => 'Designation',
                'mobile_no' => 'Contact No',
                'status' => 'Status',

            ],
            'user_ids' => [
                'user_type' => 'User ID Type',
                'parent_id' => 'System Name or Asset ID',
                'user_id' => 'User ID',
                'description' => 'Description',
                'right_id' => 'User ID Rights',

            ],
            'hardware_legacies' => [
                'type' => 'Asset Type',
                'hardware_make' => 'Make',
                'hardware_model' => 'Model',
            ],
            'software_legacies' => [
                'software_type' => 'Software Type',
                'software_name' => 'Software Name',
                'software_version' => 'Software Version',
                'status' => 'Legacy Status',

            ],

        ];

        $tableMap = $mappingArray[$table];
        if ($method == "export")
            return array_values($tableMap);
        $column = sanitizeInput($column);
        if ($method == "import")
            return array_search($column, $tableMap);
    }
}

if (!function_exists('tableNamesMapping')) {
    function tableNamesMapping($table, $method)
    {
        $mappingArray = [
            'companies' => 'Company',
            'units' => 'Unit',
            'sites' => 'Site',
            'sub_sites' => 'SubSite',
            'buildings' => 'Building',
            'rooms' => 'Room',
            'cabinets' => 'Cabinet',
            'computer_assets' => 'Asset Computer',
            'network_assets' => 'Asset Network',
            'lone_assets' => 'Asset L01',
            'attachments' => 'Attachment',
            'standard_clauses' => 'Standard Clauses',
            'firewall_managments' => 'Firewall Managment',
            'hardware_legacies' => 'Hardware Legacy',
            'software_legacies' => 'Software Legacy',
            'clauses' => 'Clause',
            'users' => 'User',
            'user_ids' => 'User ID',
        ];

        if ($method == "export")
            return $mappingArray[$table];
        if ($method == "import")
            return array_search($table, $mappingArray);
    }
}

if (!function_exists('attachments')) {
    function attachments()
    {
        $attachments = Attachment::get();
        return $attachments;
    }
}

if (!function_exists('checkIfPatchApproved')) {
    function checkIfPatchApproved($patchId, $softwareId)
    {
        $approved = \App\Models\PatchPolicy::where('software_id', $softwareId)->where('patch_id', $patchId)->where('approved', 1)->first();
        return $approved;
    }
}


if (!function_exists('getComplianceStatus')) {
    function getComplianceStatus($version, $id, $location)
    {

        $data = \App\Models\ComplianceVersionItem::with('attachments.attachment.attachmentItems')->where([
            'compliance_version_id' => $version,
            'clause_id' => $id,
            'location_id' => $location,
        ])->first();

        return $data;
    }
}

if (!function_exists('getColumnLable')) {
    function getColumnLable($key)
    {
        $columnLableValue = \App\Models\ColumnLables::select('value')->where('key', $key)->first();
        if ($columnLableValue)
            $columnLableValue = $columnLableValue->value;
        else
            $columnLableValue = $key;

        return $columnLableValue;
    }
}

if (!function_exists('getAllParents')) {
    function getAllParents()
    {
        return \App\Models\Parentable::getAllParents();
    }
}

if (!function_exists('getAssetFunctions')) {
    function getAssetFunctions()
    {
        return \App\Models\AssetFunction::all();
    }
}
if (!function_exists('getFunctionsWiseAssetCount')) {
    function getFunctionsWiseAssetCount($function_id)
    {
        return \App\Models\Location::where('function', $function_id)->get()->count();
    }
}

if (!function_exists('getAncestorsForLocation')) {
    function getAncestorsForLocation($locationId)
    {
        return \App\Models\Location::ancestorsAndSelf($locationId);
    }
}
if (!function_exists('getAncestors')) {
    function getAncestors($locationId)
    {
        return \App\Models\Location::ancestorsOf($locationId);

    }
}

if (!function_exists('getUserAsset')) {
    function getUserAsset($userId)
    {
        $userAccountId = UserAccount::where('account_id', $userId)->get();
        $userAssets = AssetUserId::select('asset_id')->whereIn('user_id', $userAccountId->account_id)->get();
        $userAssetName = \App\Models\Location::where('id', $userAssets->asset_id)->first();
        return $userAssetName;

    }
}

if (!function_exists('getOTCMUser')) {
    function getOTCMUser()
    {
        $users = User::where('user_type', 'OTCM-USERS')->get();
        return $users;

    }
}

if (!function_exists('assetRights')) {
    function assetRights($rightId)
    {
        $rights = \App\Models\Right::where('id', $rightId)->first();
        return $rights;
    }
}
if (!function_exists('checkNetworkOfIpAddress')) {
    function checkNetworkOfIpAddress($ipAddress)
    {
        $networks = \App\Models\Networks::all();

        foreach ($networks as $network) {
            $high_ip = ip2long($network->end_ip);
            $low_ip = ip2long($network->start_ip);
            $ip = ip2long(trim($ipAddress));
            if ($ip <= $high_ip && $low_ip <= $ip) {
                return $network->name ?? '';
            }
        }
        return "No network found for ip address";
    }
}
if (!function_exists('checkNetworkOfIpAddressHtml')) {
    function checkNetworkOfIpAddressHtml($ipAddress)
    {
        $networks = \App\Models\Networks::all();

        foreach ($networks as $network) {
            $high_ip = ip2long($network->end_ip);
            $low_ip = ip2long($network->start_ip);
            $ip = ip2long(trim($ipAddress));
            if ($ip <= $high_ip && $low_ip <= $ip) {
//                return $network->name ?? '';
                $data = $network;
                return view("nozomi_report.tooltip_data", compact("data"));
            }
        }
        return "No network found for ip address";
    }
}

if (!function_exists('checkIfPatchPolicyCanBeDeleted')) {
    function checkIfPatchPolicyCanBeDeleted($softwareId, $patchId)
    {
        $baseSoftware = \App\Models\Software::with('patches')->where('id', $softwareId)->first();
        $patches = $baseSoftware->patches->pluck('id')->toArray();
        $patchesInstalled = \App\Models\InstalledPatch::where([
            'patch_id' => $patchId
        ])->pluck('asset_id')->toArray();
        $basePatchesInstalled = \App\Models\InstalledPatch::whereIn(
            'patch_id', $patches
        )->pluck('asset_id')->toArray();

        return count(array_intersect($patchesInstalled, $basePatchesInstalled)) > 0;
    }
}

function buildTree(array $elements, $parentId = 0)
{
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['nodes'] = $children;
            }
            $element['href'] = url('view/assets/' . $element['id'] . '/0');
            $branch[] = (object)$element;
        }
    }

    return $branch;
}

function getClauses($standardId)
{
    return StandardClause::where('standard_id', $standardId)->get();
}

function getBaseLineRiskScore($value)
{
    $consequence = getConfiguration("consequence_level");
    $threatLevel = getConfiguration("threat_level");

    if ($consequence && $threatLevel) {
        return $consequence * $threatLevel * $value;
    }

    return 0;
}

function getSecurityControlLabel($value)
{
    return \App\Models\SecurityControl::where("value", $value)->first()->name ?? '';
}

function getClauseTree($standardId, $clauseId)
{
    if (\Illuminate\Support\Facades\Cache::has('clauseCached' . $standardId) && getConfiguration("clause_update") != "1") {
        return \Illuminate\Support\Facades\Cache::get('clauseCached' . $standardId);
    } else {
        $tree = [];
        $query = StandardClause::where('standard_id', $standardId)->select('id')->where('parent_id', null);
        if ($clauseId) {
            $query = $query->where('id', $clauseId);
        }
        $locations = $query->get()->toArray();
        foreach ($locations as $location) {
            $nodes = StandardClause::descendantsAndSelf($location['id'])->toFlatTree()->toArray();
            $subTree = buildClauseTree($nodes, $location['id']);
            $parentNode = $nodes[0];
            $parentNode['nodes'] = $subTree;
            $nodeTree[0] = (object)$parentNode;
            $tree = array_merge($tree, $nodeTree);
        }
        \Illuminate\Support\Facades\Cache::forever('clauseCached' . $standardId, $tree);
        return $tree;
    }
}

function buildClauseTree(array $elements, $parentId = 0)
{
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildClauseTree($elements, $element['id']);
            if ($children) {
                $element['nodes'] = $children;
            }
            $branch[] = (object)$element;
        }
    }

    return $branch;
}

function getPatchAssets($patch)
{
    $software = $patch->software_id;
    $insSoft = \App\Models\InstalledSoftware::with('asset')->where('software_id', $software)->get();
    $asset = [];
    foreach ($insSoft as $soft) {
        $asset[] = $soft->asset;
    }

    return collect($asset);
}

function getAssetPatches($assetId)
{
    $insSoft = \App\Models\InstalledSoftware::with('software.patches')->where('asset_id', $assetId)->get();
    $patches = [];
    foreach ($insSoft as $soft) {
        foreach ($soft->software->patches as $patch) {
            $patches[] = $patch;
        }
    }

    return collect($patches);
}

function checkIfPatchInstalled($asset, $patch)
{
    return \App\Models\InstalledPatch::where('asset_id', $asset->id)->where('patch_id', $patch->id)->first();
}

function getApprovedStatus($asset, $patch)
{
    $assetSoftwares = $asset->softwares;
    $status = [];
    foreach ($assetSoftwares as $software) {
        if ($software->software->id != $patch->software->id) {
            if ($software->software->approval_required == 1) {
                $patchApproved = \App\Models\PatchPolicy::where('software_id', $software->software->id)->where('patch_id', $patch->id)->first();
                if ($patchApproved)
                    $status[$patchApproved->approved][] = $software->software;
                else
                    $status[0][] = $software->software;
            } else {
                $status[1][] = $software->software;
            }
        }

    }

    return [
        'status' => !isset($status[0]) || count($status[0]) == 0 ? 'Yes' : 'No',
        'approved' => $status[1] ?? [],
        'pending' => $status[0] ?? [],
    ];
}

function getAttchments()
{
    return Attachment::all();
}

function getComplianceVersionItem($versionId, $clauseId, $locationId, $column = 'compliant')
{
    $versionItem = \App\Models\ComplianceVersionItem::where([
        'compliance_version_id' => $versionId,
        'clause_id' => $clauseId,
        'location_id' => $locationId,
    ])->first();
    if ($column && $versionItem)
        return $versionItem->{$column};
    if (!$versionItem)
        return 4;

    return $versionItem;
}

function getColors($index)
{
    $arr = [
        "255",
        "0",
        "0",
    ];
}

function getPercent($number, $divider, $precision = 2)
{
    if ($divider == 0) return 0;
    return number_format(($number / $divider) * 100, $precision);
}

function divideNumber($number, $divider, $precision = 2)
{
    if ($divider == 0) return 0;
    return number_format(($number / $divider), $precision);
}

function getTypeForPermission($model)
{
    $assetCondition = assetCondition($model);
    $type = "hierarcy";
    if ($assetCondition) {
        $type = $assetCondition;
    }

    return $type;
}

function checkIfButtonAllowed($locations, $item, $action)
{
    $viewPermissions = $locations->where('action', $action)->pluck('location');
    foreach ($viewPermissions as $location) {
        if ($item->isDescendantOf($location) || $item->id == $location->id) {
            return true;
        }
    }
    return false;
}

function getUserLocations()
{
    $locations = Role::locationsArray();
//    $nodes = [];
//    foreach ($locations as $location) {
//        $loca = Location::descendantsAndSelf($location)->sortBy('short_name')->toFlatTree()->pluck('id')->toArray();
//        foreach ($loca as $item){
//            $nodes[] = $item;
//        }
//    }
    return $locations;
}

function getLocationsForDropDown($type, $action, $model = null, $itemSiblings = false, $item = null, $itemChilds = null)
{
    $locations = \App\Models\Location::applyLocationFilter(null, $model, null, null, $action, true, true)->get();
    if ($type && !$itemSiblings) {
        $types = \App\Models\Location::getHierarchyLevelForCreation($type);
        $locations = $locations->whereIn('type', $types);
    } elseif ($type && $itemSiblings && $item) {
        $locations = $locations->where('type', $type);
        $locations = $locations->where('parent_id', $item->parent_id);
    } elseif ($itemChilds && $item) {
        $locations = $locations->where('parent_id', $item->id);
    }

    $sorted = [];
    foreach ($locations as $location) {
        $sorted[$location->type][] = $location;
    }

    return $sorted;
}

function getFilterHtml($columns)
{
    return view('components.columns_filter')->with(['columns' => $columns])->render();
}

function processQueryFiltersOnQuery($query, $crOperation, $crWhere, $crValue)
{
    if ($crOperation == "LIKE %%")
        $query = $query->where($crWhere, 'LIKE', '%' . $crValue . '%');
    else if ($crOperation == "IN")
        $query = $query->where($crWhere, 'IN', $crValue);
    else if ($crOperation == "NOT IN")
        $query = $query->where($crWhere, 'NOT IN', $crValue);
    else
        $query = $query->where($crWhere, $crOperation, $crValue);

    return $query;
}

function getGapLabelForStandard($value, $standardId)
{
    $standardLabel = \App\Models\GapRating::where('standard_id', $standardId)->where('value', $value)->first();
    if ($standardLabel)
        return $standardLabel->name;
    $standardLabel = \App\Models\GapRating::whereNull('standard_id')->where('value', $value)->first();
    return $standardLabel->name ?? '';
}

function getGapsForStandard($standardId)
{
    $response = [];
    for ($index = 1; $index < 6; $index++) {
        $response[$index] = getGapLabelForStandard($index, $standardId);
    }

    return $response;
}

function getColorForRisk($value)
{
    if ($value < 1)
        $value = 1;
    $riskRating = \App\Models\RiskRating::where('from', '<=', $value)->where('to', '>=', $value)->first();

    return $riskRating->color ?? '';
}

function getTitleForRisk($value)
{
    $riskRating = \App\Models\RiskRating::where('from', '<=', $value)->where('to', '>=', $value)->first();

    return $riskRating->name ?? '';
}


function getScoresForAVersion($versionId)
{
    try {
        $threatLevel = getConfiguration("threat_level");
        $consequenceLevel = getConfiguration("consequence_level");
        $version = \App\Models\ComplianceVersion::find($versionId);
        $applicableClauses = \App\Models\StandardClause::where('applicable', 1)->where('is_heading', 0)->where('standard_id', $version->standard_id)
            ->select('id', 'location', 'security_control_rating')->get();

        $weightedRiskTotal = 0;
        $weightedLikeLiHoodTotal = 0;
        $weightedConsequence = 0;
        $weightedConsequenceTotal = 0;
        $count = 0;
        foreach ($applicableClauses as $applicableClause) {
            $weightage = $applicableClause->security_control_rating;
            if ($applicableClause->location != "") {
                $locationModel = 'App\Models\\' . $applicableClause->location;
                $locations = $locationModel::pluck('id')->toArray();
                foreach ($locations as $location) {
                    $gapRating = 4;
                    $compliant = \App\Models\ComplianceVersionItem::where('compliance_version_id', $versionId)
                        ->where('location_id', $location)
                        ->where('clause_id', $applicableClause->id)
                        ->select('compliant')->first();

                    $weightedConsequence = $consequenceLevel * $weightage;
                    if ($compliant) {
                        $gapRating = $compliant->compliant;
                    }
                    $weightedLikeLiHood = $threatLevel * $gapRating;
                    $riskScore = $weightedLikeLiHood * $weightedConsequence;
                    $weightedConsequenceTotal += $weightedConsequence;

                    $weightedRiskTotal += $riskScore;
                    $weightedLikeLiHoodTotal += $weightedLikeLiHood;
                    $count += 1;
                }
            }
        }
        $riskScore = $weightedRiskTotal / $count;
        $likeLiHoodScore = $weightedLikeLiHoodTotal / $count;
        $consequenceScore = $weightedConsequenceTotal / $count;

        return [
            "riskScore" => number_format($riskScore, 2),
            "consequenceScore" => number_format($consequenceScore, 2),
            "likeLiHoodScore" => number_format($likeLiHoodScore, 2)
        ];
    } catch (Exception $exception) {
        return ["riskScore" => 0, "likeLiHoodScore" => 0];
    }
}

function getRiskScoreForComplianceVersion($versionId)
{
    $consequence = getConfiguration("consequence_level");
    $likeHoodScore = getLikeLiHoodScoreForComplianceVersion($versionId);
    return number_format($consequence * $likeHoodScore, 2);
}

function resetClauseCache()
{
    \App\Models\Configuration::updateOrCreate(
        ["name" => "clause_update"]
        ,
        ["value" => 1]
    );
}

function getThreatLevels()
{
    return \App\Models\ThreatLevel::orderBy('value', 'desc')->get();
}

function getConsequenceLevels()
{
    return \App\Models\ConsequenceLevel::orderBy('value', 'desc')->get();
}


function getSecurityControl()
{
    return \App\Models\SecurityControl::orderBy('value', 'desc')->get();
}

function getGapRatings()
{
    return \App\Models\GapRating::whereNull('standard_id')->orderBy('value', 'desc')->get();
}

function getMarkerPositionForVersion($start, $end, $value)
{
    $value = abs($value);
    $middle = ($start + $end) / 2;
    $interval = $end - $middle;
    $difference = abs($middle - $value);
    if ($value > $middle) {
        return abs(($difference / $interval)) * -1 * 25;
    } else {
        return abs(($difference / $interval)) * 15;
    }
}
