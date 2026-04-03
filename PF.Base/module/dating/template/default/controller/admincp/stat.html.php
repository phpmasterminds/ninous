<?php
/**
 * [PHPFOX_HEADER]
 */

defined('PHPFOX') or exit('NO DICE!');

/**
 *
 *
 * @copyright		[FOXEXPERT_COPYRIGHT]
 * @author  		Belan Ivan
 * @package  		Module_Dating
 */
?>
<div class="table_header">
    {_p var='Dating Statistic'}
</div>
<table  cellpadding="0" cellspacing="0" style="width:100%">
    <tr>
        <td colspan="10"><h1>{_p var='Main Information'}</h1></td>
    </tr>
    <tr>
        <th>{_p var='Total Likes'}</th>
        <th>{_p var='Total Mutual Likes'}</th>
        <th>{_p var='Total Skipped'}</th>
        <th>{_p var='Total Favourites'}</th>
    </tr>
    <tr class="tr">
        <td>
            {$stats.total_like} {_p var='likes'}
        </td>
        <td>
            {$stats.total_mutual} {_p var='mutual likes'}
        </td>
        <td>
            {$stats.total_skip} {_p var='users'}
        </td>
        <td>
            {$stats.total_favourite} {_p var='users'}
        </td>
    </tr>
    <tr>
        <td colspan="10"><h1>{_p var='Content'}</h1></td>
    </tr>
    <tr>
        <th>{_p var='Total Photos'}</th>
        <th>{_p var='Total Videos'}</th>
    </tr>
    <tr class="tr">
        <td>
            {$stats.total_photo}
        </td>
        <td>
            {$stats.total_video}
        </td>
    </tr>
    <tr>
        <td colspan="10"><h1>{_p var='Users'}</h1></td>
    </tr>
    <tr>
        <th>{_p var='Total Sponsored'}</th>
        <th>{_p var='Total Excluded users'}</th>
        <th>{_p var='Total filled dating fields'}</th>
    </tr>
   <tr class="tr">
       <td>
           {$stats.total_sponsor}
       </td>
       <td>
           {$stats.total_exclude}
       </td>
       <td>
           {$stats.total_field}
       </td>
    </tr>
</table>
