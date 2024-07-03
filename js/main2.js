function checkScreenSize() {
    const breakpoint = 900; // Set your breakpoint here
    const element = document.querySelector('.sidebar'); // Change to your element's class

    if (window.innerWidth <= breakpoint) {
        // Add the class if the screen width is less than or equal to 768px
        element.classList.add('close');
    } else {
        // Remove the class if the screen width is greater than 768px
        element.classList.remove('close');
    }
}
checkScreenSize();
window.addEventListener('resize', checkScreenSize);



// let arrow = document.querySelectorAll(".arrow");

// for (var i = 0; i < arrow.length; i++) {
//     arrow[i].addEventListener("click", (e) => {
//         let arrowParent = e.target.parentElement.parentElement;//selecting main parent of arrow
//         arrowParent.classList.toggle("showMenu");
//     });
// }

let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".bx-menu");
// console.log(sidebarBtn);
sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("close");
});

// make buttons active class
let sideMenuButtons = document.querySelectorAll("#sideMenuButtons li button");

sideMenuButtons.forEach(item => {
    if (item.classList.contains('active')) {
        item.innerHTML = item.textContent.trim() + ' <i class="bx bx-minus" ></i>';
        item.parentNode.nextElementSibling.querySelectorAll('ul li').forEach(li => {
            li.style.display = '';
        });
    } else {
        item.innerHTML = item.textContent.trim() + ' <i class="bx bx-plus"></i>';
        item.parentNode.nextElementSibling.querySelectorAll('ul li').forEach(li => {
            li.style.display = 'none';
        });
    }
})


for (let i = 0; i < sideMenuButtons.length; i++) {
    sideMenuButtons[i].addEventListener("click", (_) => {
        sideMenuButtons.forEach((sideMenuButton) => {
            sideMenuButton.classList.remove("active");
        });

        sideMenuButtons.forEach(item => {
            if (item.classList.contains('active')) {
                item.innerHTML = item.textContent.trim() + ' <i class="bx bx-minus" ></i>';
            } else {
                item.innerHTML = item.textContent.trim() + ' <i class="bx bx-plus"></i>';
            }
        })

        const ul = sideMenuButtons[i].parentNode.nextElementSibling;
        const isExpanded = ul.querySelector("li").style.display !== 'none';

        document.querySelectorAll('ul.list li').forEach(li => {
            li.style.display = 'none';
        });


        if (isExpanded) {
            ul.querySelectorAll('li').forEach(li => {
                li.style.display = 'none';

                sideMenuButtons[i].innerHTML = sideMenuButtons[i].textContent.trim() + ' <i class="bx bx-plus"></i>';
            });
        } else if (ul && ul.classList.contains('list')) {
            ul.querySelectorAll('li').forEach(li => {
                li.style.display = li.style.display === 'none' ? '' : 'none';

                sideMenuButtons[i].innerHTML = sideMenuButtons[i].textContent.trim() + ' <i class="bx bx-minus" ></i>';
            });
        }

        sideMenuButtons[i].classList.add("active");
    });
}

function currentLink() {
    var checkUrl = ["create", "view", "delete", "edit", "summary", "download", "upload"];
    
    var currentURL = window.location.href;
    
    for (var i = 0; i < checkUrl.length; i++) {
        if (currentURL.includes(checkUrl[i])) {
            if (sideMenuButtons[i]) {
                sideMenuButtons[i].click();
                break;
            }
        }
    }

}

currentLink();


const toggleButton = document.getElementById('table-toggle-button');
const content = document.getElementById('table-options');

toggleButton.addEventListener('click', function () {
    if (content.style.display === 'none') {
        content.style.display = 'block';
        toggleButton.innerHTML = "Hide Options";
    } else {
        content.style.display = 'none';
        toggleButton.innerHTML = "Show Options";
    }
});

document.body.addEventListener('click', function (event) {
    if (event.target !== toggleButton && event.target !== content) {
        content.style.display = 'none';
        toggleButton.innerText = "Show Options";
    }
})



$_tname = (d3 = document, temp) => {
    return d3.getElementsByTagName(temp);
};

table = $_tname(document, "table")[0];
thead = $_tname(table, "thead")[0];
tbody = $_tname(table, "tbody")[0];

// search
$_tname(document, "input")[0].addEventListener("search", (e) => {
    // Search Variable
    input = $_tname(document, "input")[0].value;
    filter = input.toUpperCase();
    tr = $_tname(tbody, "tr");

    // Search filter
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        display = false;

        // Loop through all td elements in the current tr
        for (j = 0; j < td.length; j++) {
            if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
                display = true;
                break; // If any column matches, no need to continue checking
            }
        }

        // Search tr Display
        if (display) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
});

// Selected Display
function sel() {

    var headers = document.querySelectorAll("#table-options div").length;

    cl1 = $_tname(table, "colgroup")[0];
    cl2 = $_tname(cl1, "col");
    li1 = $_tname(thead, "tr");
    th1 = $_tname(li1[0], "th");
    li2 = $_tname(tbody, "tr");

    for (j = 0; j < headers; j++) {
        window[`c${j}`] = $_tname(document, "input")[`${j + 1}`].checked;
        if (window[`c${j}`]) {
            cl2[j].style.display = "";
            th1[j].style.display = "";
        } else {
            cl2[j].style.display = "none";
            th1[j].style.display = "none";
        }
    }

    for (i = 0; i < li2.length; i++) {
        for (k = 0; k < headers; k++) {
            if (window[`c${k}`]) {
                $_tname(li2[i], "td")[k].style.display = "";
            } else {
                $_tname(li2[i], "td")[k].style.display = "none";
            }
        }
    }
}

//asc sort
function tsort(temp) {
    var rows = table.rows;
    var switching = true;

    while (switching) {
        switching = false;
        for (var i = 1; i < rows.length - 1; i++) {
            var x = $_tname(rows[i], "TD")[temp];
            var y = $_tname(rows[i + 1], "TD")[temp];
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                break;
            }
        }
    }
}

//sort
function tsort2(temp) {
    var rows = Array.from(table.rows);
    rows.shift();
    rows.sort(function (a, b) {
        var x = a.cells[temp].textContent;
        var y = b.cells[temp].textContent;

        if (!isNaN(x) && !isNaN(y)) {
            return x - y;
        } else {
            return x.localeCompare(y);
        }
    });
    rows.forEach(function (row) {
        tbody.appendChild(row);
    });
}

// desc sort
function tsort3(temp) {
    var rows = Array.from(table.rows);
    rows.shift();
    rows.sort(function (a, b) {
        var x = a.cells[temp].textContent;
        var y = b.cells[temp].textContent;

        if (!isNaN(x) && !isNaN(y)) {
            return y - x;
        } else {
            return y.localeCompare(x);
        }
    });
    rows.forEach(function (row) {
        tbody.appendChild(row);
    });
}

x = 1;
oldx = 1;
y = 1;
oldy = 1;
document.addEventListener("keydown", (e) => {
    switch (e.key) {
        case "ArrowUp":
            oldx = x;
            oldy = y;
            x = x - 1;
            break;
        case "ArrowDown":
            oldx = x;
            oldy = y;
            x = x + 1;
            break;
        case "ArrowLeft":
            oldx = x;
            oldy = y;
            y = y - 1;
            break;
        case "ArrowRight":
            oldx = x;
            oldy = y;
            y = y + 1;
            break;
        default:
            // console.log(e.key);
            break;
    }
    table.rows[oldx].cells[oldy].style.border = "1px solid #888";
    table.rows[x].cells[y].style.border = "2px solid red";
    // console.log(table.rows[x].cells[y].innerHTML);
});

/* if scroll */
const observer = new IntersectionObserver(
    ([e]) => {
        e.target.classList.toggle("isSticky", e.intersectionRatio < 1);
    },
    { threshold: [1] }
);
observer.observe(thead);

// scrollY test
window.addEventListener("scroll", (e) => {
    thead.classList.toggle("isSticky2", window.scrollY >= 800);
    thead.classList.toggle(
        "isSticky3",
        window.scrollY >= 400 && window.scrollY <= 600
    );
});

function changeStore() {
    var storeSelectElement = document.getElementById('store-selection');
    storeSelectElement.addEventListener('change', function() {
        document.getElementById('store-selection-form').submit();
    });
}

function validateFileSize() {
    const fileInput = document.getElementById('fileToUpload');
    const maxSize = 2 * 1024 * 1024; // 2 MB in bytes

    if (fileInput.files[0].size > maxSize) {
        alert("The file is too large. Maximum size is 10MB.");
        fileInput.value = ''; // Clear the file input
        return false;
    }
    return true;
}