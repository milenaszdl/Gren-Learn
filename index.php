<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Главная");
?>
<div class="white">
    <div class="row-content">
        <h3 class="gradient">
        gren-Learn - портал, предназначенный для обмена опытом и профессионального развития веб-разработчиков компании АО «Гринатом».
        <br><br>
        Его основное назначение заключается в создании единой цифровой платформы, которая обеспечивает удобное и эффективное управление образовательным процессом, позволяет отслеживать прогресс сотрудников и способствует их профессиональному росту.
        </h3>
        <img src="/upload/images/5.png" width=400px;>
    </div>
<br><br>
    <?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"plitki", 
	array(
		"COMPONENT_TEMPLATE" => "plitki",
		"ROOT_MENU_TYPE" => "top",
		"MENU_CACHE_TYPE" => "N",
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MAX_LEVEL" => "1",
		"CHILD_MENU_TYPE" => "left",
		"USE_EXT" => "N",
		"DELAY" => "N",
		"ALLOW_MULTI_SELECT" => "N",
		"MENU_THEME" => "site"
	),
	false
);?>
</div>


<style>
    .white {
        background-color: white;
        padding: 50px;
        border-radius: 30px;
        display: flex;
        flex-direction: column;
    }

    .gradient {
        background: linear-gradient(to left, #a5af36, #226100);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .row-content {
        display: flex;
        flex-direction: row;
    }
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>