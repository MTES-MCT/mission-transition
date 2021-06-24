import './styles/homepage.scss';
import Isotope from 'isotope-layout'

// $('#tag-filter-content').isotope({
//     // main isotope options
//     itemSelector: '.card-package',
//     // set layoutMode
//     layoutMode: 'cellsByRow',
//     // options for cellsByRow layout mode
//     cellsByRow: {
//         columnWidth: 275,
//         rowHeight: 357
//     },
//     // options for masonry layout mode
//     masonry: {
//         columnWidth: '.grid-sizer'
//     }
// })

document.addEventListener("DOMContentLoaded", function() {
    var elem = document.querySelector('#tag-filter-content');
    var iso = new Isotope( elem, {
        // options
        itemSelector: '.card-package',
        layoutMode: 'fitRows',
        fitRows: {
            gutter: 32
        }
    });

    document.addEventListener('click', function (event) {

        if (!event.target.matches('.sort-package')) return;
        event.preventDefault();
        var filterValue = event.target.getAttribute('data-filter');
        iso.arrange({ filter: filterValue });

    }, false);
});
