document.addEventListener('DOMContentLoaded', () => {
    // Все таблицы в которых будет осуществлена сортировка по thead
    const theads = document.querySelectorAll(".table_sort thead");

    theads.forEach(thead => thead.addEventListener("click", evt => getSort(evt)));

    const nameColumn = document.querySelector("#name");
    nameColumn.dataset.order = 1;
    
    const getSort = ({ target }) => {
        const order = (target.dataset.order = -(target.dataset.order || -1));
        const thList = Array.from(target.parentNode.cells);
        const index = thList.indexOf(target);
        const collator = new Intl.Collator(['en', 'ru'], { numeric: true });
        const comparator = (index, order) => (a, b) => order * collator.compare(
            a.children[index].innerHTML,
            b.children[index].innerHTML
        );

        for(const tBody of target.closest('table').tBodies)
            tBody.append(...[...tBody.rows].sort(comparator(index, order)));

        for(const cell of target.parentNode.cells)
            cell.classList.toggle('sorted', cell === target);
    };
    getSort({ target: nameColumn });
});

//Подтверждение удаления из бд
function del() {
    if (!confirm("Вы подтверждаете операцию?")){
        alert ('Выполнение отменено');
        return false;
    }
};

function updateDirectory(id) {
    window.location.href = '../directory/update_directory.php?id=' + id;
}

function deleteFromDirectory(id) {
    if (confirm("Вы уверены, что хотите удалить запись?")) {
            fetch('../directory/delete_from_directory.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id=' + id
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert("Ошибка при удалении записи");
                }
            })
            .catch(error => {
                console.error('Ошибка:', error);
            });
        }
}