<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<div class="container">
  <div class="row">
    <?php foreach ($arResult as $arItem): ?>
      <div class="col-md-3 mb-5">
        <div class="tile">
          <a href="<?= $arItem["LINK"] ?>" class="btn btn-light btn-block">
            <h4 class="tile-title">
              <?=$arItem["TEXT"]?>
            </h4>
            <img src="/upload/icons/code-icon.svg" style="width:50px;">
          </a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<style>
  .tile {
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 15px;
    /* text-align: center; */
    background: linear-gradient(to bottom, #a5af36, #226100);
    width: 250px;
    height: 200px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;

  }

  .tile:hover {
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transform: translateY(-10px);
    transition: all 0.3s ease;
  }

  .tile:active {
    background-color: #F5FFEA !important;
  }

  .tile a {
    background-color:rgba(165, 175, 54, 0);
    border:none;
  }

  .tile a:hover {
    background-color:rgba(165, 175, 54, 0);
  }

  .tile a:focus {
    background-color:rgba(165, 175, 54, 0) !important;
  }

  .tile a:active {
    background-color:rgba(165, 175, 54, 0) !important;
  }

  .tile-title {
    color:#F5FFEA !important;
    font-size: 18px;
    font-weight: bold;
    margin-bottom: 0px !important;
  }

  .row {
    width: 100% !important;
    justify-content: center;
  }

  .row {
    margin-top: 30px !important;
  }
</style>