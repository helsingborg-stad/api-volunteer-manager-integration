<?php /** @noinspection FunctionSpreadingInspection */

namespace APIVolunteerManagerIntegration\PostTypes\Assignment\Controller\Model;

use APIVolunteerManagerIntegration\Helper\WP;

class EmployerInfo
{
    public function data(): array
    {
        $toString            = fn(array $arr): string => $arr['value'];
        $wrapValueWithAnchor = fn(array $arr): array => array_merge($arr, [
            'value' => filter_var($arr['value'],
                FILTER_VALIDATE_URL) ? "<a href='{$arr['value']}'>{$arr['value']}</a>" : $arr['value'],
        ]);
        $wrapValueWithLabel  = fn(array $arr): array => array_merge($arr, [
            'value' => ! empty($arr['label']) ? '<span>'.$arr['label'].':</span> '.$arr['value'] : $arr['value'],
        ]);

        $maybeReturnEmployerData = fn(array $arr
        ): array => ! empty($arr['employer']) || ! empty($arr['instructions']) ? $arr : [];

        return $maybeReturnEmployerData([
            'title'        => __(
                'About the employer',
                API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN
            ),
            'instructions' => WP::getPostMeta('employer_about', ''),
            'employer'     =>
                array_map($toString,
                    array_map($wrapValueWithLabel,
                        array_map($wrapValueWithAnchor,
                            array_filter([
                                [
                                    'label' => __('Organisation', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                                    'value' => trim(WP::getPostMeta('employer_name', '')),
                                ],
                                [
                                    'label' => __('Website', API_VOLUNTEER_MANAGER_INTEGRATION_TEXT_DOMAIN),
                                    'value' => trim(WP::getPostMeta('employer_website', '')),
                                ],

                            ], fn($arr) => ! empty($arr['value'])),
                        ),
                    ),
                ),
        ]);
    }
}