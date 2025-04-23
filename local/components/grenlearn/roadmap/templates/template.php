<?php if (!empty($arResult["TOPICS"])): ?>
    <div class="roadmap">
    <h2 class="roadmap-header"><?= htmlspecialchars($arResult["ROADMAP_NAME"]) ?></h2>
    <svg class="roadmap-svg" xmlns="http://www.w3.org/2000/svg">
    <defs>
    <linearGradient id="gradient-line" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0%" stop-color="#3F8718" /> <!--начальный цвет -->
      <stop offset="100%" stop-color="#3F8718" /> <!--конечный цвет -->
    </linearGradient>
  </defs>
    </svg>
    <div class="roadmap-flow">
        <?php
        //группировка тем по уровню сортировки
        $sortedTopics = [];
        foreach ($arResult["TOPICS"] as $topic) {
            $sortedTopics[$topic["SORT"]][] = $topic;
        }

        //отрисовка тем по уровням
        foreach ($sortedTopics as $level => $topics): ?>
            <div class="roadmap-level">
                <?php foreach ($topics as $topic): ?>
                    <div class="roadmap-item-wrapper">
                        <!--основная тема -->
                        <div class="roadmap-item"  data-sort-order="<?= htmlspecialchars($topic["SORT"]) ?>" data-topic-name="<?= htmlspecialchars($topic["NAME"]) ?>" data-topic-description="<?= htmlspecialchars($topic["DESCRIPTION"]) ?>">
                            <?= htmlspecialchars($topic["NAME"]) ?>
                        </div>

                        <!--вертикальная линия к подтемам
                        <?php //if (!empty($topic["SUBTOPICS"])): ?>
                            <div class="roadmap-connector-level"></div>
                        <?php //endif; ?> -->

                        <!--подтемы -->
                        <?php if (!empty($topic["SUBTOPICS"])): ?>
                            <div class="roadmap-subtopics">
                                <?php foreach ($topic["SUBTOPICS"] as $subtopic): ?>
                                    <div class="roadmap-subitem-wrapper">
                                        <!--горизонтальная линия
                                        <div class="roadmap-connector"></div> -->
                                        <!--подтема -->
                                        <div class="roadmap-subitem" data-topic-name="<?= htmlspecialchars($subtopic["NAME"]) ?>" data-topic-description="<?= htmlspecialchars($subtopic["DESCRIPTION"]) ?>">
                                            <?= htmlspecialchars($subtopic["NAME"]) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div id="modal" class="modal">
    <span class="modal-close">&times;</span> <!-- Крестик -->
    <div class="modal-header">
        <h2 id="modal-title" class="modal-title"></h2> <!-- Заголовок -->
    </div>
    <div class="modal-content">
        <p id="modal-description"></p> <!-- Описание -->
    </div>
</div>

<?php else: ?>
    <p>Нет доступных тем для отображения.</p>
<?php endif; ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const svg = document.querySelector('.roadmap-svg');
    const roadmap = document.querySelector('.roadmap');
    const levels = document.querySelectorAll('.roadmap-level');

    const roadmapRect = roadmap.getBoundingClientRect();

    function createPath(x1, y1, x2, y2) {
        const curve = `M${x1},${y1} C${x1},${(y1 + y2) / 2} ${x2},${(y1 + y2) / 2} ${x2},${y2}`;
        const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
        path.setAttribute("d", curve);
        path.setAttribute("stroke", "url(#gradient-line)");
        path.setAttribute("stroke-width", "3");
        path.setAttribute("stroke-dasharray", "5, 5");
        path.setAttribute("fill", "none");
        svg.appendChild(path);
    }

    //генерация линий для подтем
    levels.forEach((level) => {
        const topics = level.querySelectorAll('.roadmap-item-wrapper');
        topics.forEach((topic) => {
            const topicRect = topic.getBoundingClientRect();

            const subtopics = topic.querySelectorAll('.roadmap-subitem-wrapper');
            subtopics.forEach((subtopic) => {
                const subtopicRect = subtopic.getBoundingClientRect();

                //корректируем координаты на основе смещения контейнера .roadmap
                const x1 = topicRect.right - roadmapRect.left;
                const y1 = topicRect.top + topicRect.height / 2 - roadmapRect.top;
                const x2 = subtopicRect.left - roadmapRect.left;
                const y2 = subtopicRect.top + subtopicRect.height / 2 - roadmapRect.top;

                createPath(x1, y1, x2, y2);
            });
        });
    });

    //генерация линий для соединения главных тем
    for (let i = 0; i < levels.length - 1; i++) {
        const currentLevelTopics = levels[i].querySelectorAll('.roadmap-item-wrapper');
        const nextLevelTopics = levels[i + 1].querySelectorAll('.roadmap-item-wrapper');

        currentLevelTopics.forEach((currentTopic) => {
            const currentRect = currentTopic.getBoundingClientRect();

            nextLevelTopics.forEach((nextTopic) => {
                const nextRect = nextTopic.getBoundingClientRect();

                //координаты на основе смещения контейнера .roadmap
                const x1 = currentRect.left + currentRect.width / 2 - roadmapRect.left; //центр верхней темы
                const y1 = currentRect.top + currentRect.height - roadmapRect.top; //низ верхней темы
                const x2 = nextRect.left + nextRect.width / 2 - roadmapRect.left; //центр нижней темы
                const y2 = nextRect.top - roadmapRect.top; //верх нижней темы

                createPath(x1, y1, x2, y2);
            });
        });
    }
    
    //получаем все roadmap-item
    const roadmapItems = document.querySelectorAll('.roadmap-item');

    //считаем количество элементов с одинаковым значением data-sort-order
    const sortOrderCounts = {};

    roadmapItems.forEach((item) => {
        const sortOrder = item.getAttribute('data-sort-order');
        if (sortOrder) {
            if (sortOrderCounts[sortOrder]) {
                sortOrderCounts[sortOrder]++;
            } else {
                sortOrderCounts[sortOrder] = 1;
            }
        }
    });

    //cкрываем подтемы для элементов с дублирующимися значениями data-sort-order
    roadmapItems.forEach((item) => {
        const sortOrder = item.getAttribute('data-sort-order');
        if (sortOrder && sortOrderCounts[sortOrder] > 1) {
            const parentWrapper = item.closest('.roadmap-item-wrapper');
            const subtopics = parentWrapper?.querySelector('.roadmap-subtopics');
            if (subtopics) {
                subtopics.style.display = 'none'; // Скрываем подтемы
            }
        }
    });

    //логика модального окна
    const modal = document.getElementById("modal");
    const modalTitle = document.getElementById("modal-title");
    const modalDescription = document.getElementById("modal-description");
    const closeModal = document.querySelector(".modal-close");

    // Проверяем, что roadmap-item есть на странице
    const items = document.querySelectorAll(".roadmap-item");
    if (!items.length) {
        console.error("Элементы с классом .roadmap-item не найдены!");
        return;
    }

    // Открытие модального окна
    items.forEach(item => {
        item.addEventListener("click", function () {
            const name = this.getAttribute("data-topic-name");
            const description = this.getAttribute("data-topic-description");

            if (!name || !description) {
                console.error("Атрибуты data-topic-name или data-topic-description отсутствуют!");
                return;
            }

            modalTitle.textContent = name;
            modalDescription.textContent = description;

            // Добавляем класс 'show' для отображения модального окна
            modal.classList.add("show");
        });
    });

    // Закрытие модального окна
    closeModal.addEventListener("click", function () {
        modal.classList.remove("show");
    });

    // Закрытие окна при клике вне области окна
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.classList.remove("show");
        }
    });
});

</script>
