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
{literal}
<style>
    .spacer {
        margin: 5px 0;
        width: 1px;
        height: 1px;
    }
    .filter_info {
        font-size: 12px;
        margin-bottom: 5px;
    }
    .dating_gender div.radio {
        float: left;
        margin: 0;
        margin-top: 10px;
        margin-right: 20px;
    }
    .update_dating{
        position:absolute;
        right:10px;
        top:15px;
    }
</style>
{/literal}
<form method="get" action="{url link='dating'}" id="dating_form">
<div class="row filter_fields" style="box-shadow:0 10px 20px 0 rgba(0, 0, 0, 0.08);border-radius:6px;background: #fff;padding: 10px;margin: 0px 0px 15px;position:relative">
    <div class="block"><div class="title" style="color:#555;font-weight:bold;font-size:16px;padding-left:10px;margin-bottom: 10px;border-bottom: 1px solid #ddd;padding-bottom: 10px;">{_p var='Find your Love'}</div></div>
    <div class="update_dating"><a href="{url link='dating.manage'}"><i class="fa fa-pencil" style="padding-right:4px;"></i> {_p var='update dating profile'}</a></div>
    <div class="col-sm-4" style="padding:10px;">
        <div class="filter_info">{_p var='Search keyword'}:</div>
        <input class="form-control" type="text" name="search[keyword]" value="{if !empty($aForms.keyword)}{$aForms.keyword}{/if}" size="15">
        <div class="spacer"></div>
        <div class="filter_info">{_p var='Location'}:</div>
        <select  id="js_country_child_id_value" name="search[country]" class="form-control" style="width: 100%;">
            <option value="0">{_p var='Select Country'}:</option>
            {foreach from=$aCountryChildren key=iChildId item=sChildValue}
            <option value="{$iChildId}"{if !empty($aForms)}{if $aForms.country == $iChildId} selected="selected"{/if}{/if}>{$sChildValue}</option>
            {/foreach}
        </select>
    </div>
    <div class="col-sm-4 dating_gender" style="padding:10px;">
        <div class="filter_info">{_p var='Gender'}:</div>
        <select class="form-control" name="search[gender]"><option value="1">{_p var='male'}</option>
            <option value="2">{_p var='female'}</option>
            <option value="" selected="selected">{_p var='both'}</option>
        </select>
        <div class="clear">   </div>
        <div class="spacer"></div>
        <div class="filter_info">{_p var='City'}:</div>
        <input class="form-control" type="text" name="search[city]" value="{if !empty($aForms.city)}{$aForms.city}{/if}"  size="15">            </div>
    <div class="col-sm-4" style="padding:10px;">
        <div class="filter_info">{_p var='Age'}:</div>
        <select id="datingfrom" class="form-control" name="search[from]" style="width: 48%;float: left;margin-right: 4%;padding-left:4px;">
            <option value="">{_p var='From'}:</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
            <option value="32">32</option>
            <option value="33">33</option>
            <option value="34">34</option>
            <option value="35">35</option>
            <option value="36">36</option>
            <option value="37">37</option>
            <option value="38">38</option>
            <option value="39">39</option>
            <option value="40">40</option>
            <option value="41">41</option>
            <option value="42">42</option>
            <option value="43">43</option>
            <option value="44">44</option>
            <option value="45">45</option>
            <option value="46">46</option>
            <option value="47">47</option>
            <option value="48">48</option>
            <option value="49">49</option>
            <option value="50">50</option>
            <option value="51">51</option>
            <option value="52">52</option>
            <option value="53">53</option>
            <option value="54">54</option>
            <option value="55">55</option>
            <option value="56">56</option>
            <option value="57">57</option>
            <option value="58">58</option>
            <option value="59">59</option>
            <option value="60">60</option>
            <option value="61">61</option>
            <option value="62">62</option>
            <option value="63">63</option>
            <option value="64">64</option>
            <option value="65">65</option>
            <option value="66">66</option>
            <option value="67">67</option>
            <option value="68">68</option>
            <option value="69">69</option>
            <option value="70">70</option>
            <option value="71">71</option>
            <option value="72">72</option>
            <option value="73">73</option>
            <option value="74">74</option>
            <option value="75">75</option>
            <option value="76">76</option>
            <option value="77">77</option>
            <option value="78">78</option>
            <option value="79">79</option>
            <option value="80">80</option>
            <option value="81">81</option>
            <option value="82">82</option>
            <option value="83">83</option>
            <option value="84">84</option>
            <option value="85">85</option>
            <option value="86">86</option>
            <option value="87">87</option>
            <option value="88">88</option>
            <option value="89">89</option>
            <option value="90">90</option>
            <option value="91">91</option>
            <option value="92">92</option>
            <option value="93">93</option>
            <option value="94">94</option>
            <option value="95">95</option>
            <option value="96">96</option>
            <option value="97">97</option>
            <option value="98">98</option>
            <option value="99">99</option>
            <option value="100">100</option>
            <option value="101">101</option>
            <option value="102">102</option>
            <option value="103">103</option>
            <option value="104">104</option>
            <option value="105">105</option>
            <option value="106">106</option>
            <option value="107">107</option>
            <option value="108">108</option>
            <option value="109">109</option>
            <option value="110">110</option>
            <option value="111">111</option>
            <option value="112">112</option>
            <option value="113">113</option>
            <option value="114">114</option>
            <option value="115">115</option>
            <option value="116">116</option>
            <option value="117">117</option>
        </select>
        <select class="form-control" id="datingto" name="search[to]" style="width:48%;">
            <option value="">{_p var='to'}:</option><option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
            <option value="32">32</option>
            <option value="33">33</option>
            <option value="34">34</option>
            <option value="35">35</option>
            <option value="36">36</option>
            <option value="37">37</option>
            <option value="38">38</option>
            <option value="39">39</option>
            <option value="40">40</option>
            <option value="41">41</option>
            <option value="42">42</option>
            <option value="43">43</option>
            <option value="44">44</option>
            <option value="45">45</option>
            <option value="46">46</option>
            <option value="47">47</option>
            <option value="48">48</option>
            <option value="49">49</option>
            <option value="50">50</option>
            <option value="51">51</option>
            <option value="52">52</option>
            <option value="53">53</option>
            <option value="54">54</option>
            <option value="55">55</option>
            <option value="56">56</option>
            <option value="57">57</option>
            <option value="58">58</option>
            <option value="59">59</option>
            <option value="60">60</option>
            <option value="61">61</option>
            <option value="62">62</option>
            <option value="63">63</option>
            <option value="64">64</option>
            <option value="65">65</option>
            <option value="66">66</option>
            <option value="67">67</option>
            <option value="68">68</option>
            <option value="69">69</option>
            <option value="70">70</option>
            <option value="71">71</option>
            <option value="72">72</option>
            <option value="73">73</option>
            <option value="74">74</option>
            <option value="75">75</option>
            <option value="76">76</option>
            <option value="77">77</option>
            <option value="78">78</option>
            <option value="79">79</option>
            <option value="80">80</option>
            <option value="81">81</option>
            <option value="82">82</option>
            <option value="83">83</option>
            <option value="84">84</option>
            <option value="85">85</option>
            <option value="86">86</option>
            <option value="87">87</option>
            <option value="88">88</option>
            <option value="89">89</option>
            <option value="90">90</option>
            <option value="91">91</option>
            <option value="92">92</option>
            <option value="93">93</option>
            <option value="94">94</option>
            <option value="95">95</option>
            <option value="96">96</option>
            <option value="97">97</option>
            <option value="98">98</option>
            <option value="99">99</option>
            <option value="100">100</option>
            <option value="101">101</option>
            <option value="102">102</option>
            <option value="103">103</option>
            <option value="104">104</option>
            <option value="105">105</option>
            <option value="106">106</option>
            <option value="107">107</option>
            <option value="108">108</option>
            <option value="109">109</option>
            <option value="110">110</option>
            <option value="111">111</option>
            <option value="112">112</option>
            <option value="113">113</option>
            <option value="114">114</option>
            <option value="115">115</option>
            <option value="116">116</option>
            <option value="117">117</option>
        </select>
        <div class="spacer" style="margin-bottom: 25px;"></div>
        <a href="javascript://void(0)" onclick="$('#dating_form').submit()" class="button btn-danger" style="float:right;width:100%;padding:10px;"><i class="fa fa-search" style="padding-right:3px;"></i> {_p var='Start dating'}</a>
        <div class="clear"></div>
    </div>
</div>
</form>
<script>
    {literal}$Ready(function(){{/literal}
        {if !empty($aForms.to)}
            $("#datingto").val({$aForms.to});
        {/if}
            {if !empty($aForms.from)}
                $("#datingfrom").val({$aForms.from});
            {/if}
    {literal}}){/literal}
</script>
