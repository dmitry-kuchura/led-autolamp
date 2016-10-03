<div class="rowSection">
    <script type="text/javascript" src="<?php echo Core\HTML::bmedia('js/dropzone.js'); ?>"></script>
    <div class="col-md-12 dropModule">
        <div class="widget box dropBox">
          <div class="widgetHeader myWidgetHeader">
              <div class="widgetTitle">
                  <i class="fa-download"></i>
                  Загрузка изображений
              </div>
          </div>
          <div class="widgetContent">
            <button class="btn btn-success dropAdd"><i class="fa-plus"></i> Добавить изображения</button>
            <button class="btn btn-info dropLoad" style="display: none;"><i class="fa-download"></i> Загрузить все (<span class="dropCount">0</span>)</button>
            <button class="btn btn-danger dropCancel" style="display: none;"><i class="fa-ban-circle"></i> Отменить все</button>
          </div>
          <div class="widgetContent">
             <div class="dropZone" data-config="/wezom/Config/drop1.json"></div>
          </div>
        </div>
        <div class="widget box loadedBox">
          <div class="widgetHeader myWidgetHeader">
              <div class="widgetTitle">
                  <i class="fa-file"></i>
                  Загруженные изображения
              </div>
          </div>
          <div class="widgetContent">
            <button class="btn btn-info checkAll" style="display: none;"><i class="fa-check"></i> Отметить все</button>
            <button class="btn btn-warning uncheckAll" style="display: none;"><i class="fa-ban-circle"></i> Снять все</button>
            <button class="btn btn-danger removeCheck" style="display: none;"><i class="fa-remove"></i> Удалить отмеченые</button>
          </div>
          <div class="widgetContent dropDownload"></div>
        </div>
    </div>
</div>