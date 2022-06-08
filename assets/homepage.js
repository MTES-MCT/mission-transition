import './styles/homepage.scss';
import React from 'react'
import ReactDOM from 'react-dom';
import SearchEngineExtension from "./components/SearchEngineExtension";

ReactDOM.render(
    <SearchEngineExtension/>,
    document.querySelector('#search-engine-extension')
);

let showMoreButton = document.querySelector('#show-more > .button');
showMoreButton.addEventListener('click', () => {
    let showMoreItems = document.querySelectorAll('#show-more > .hidden');
    for (let i = 0; i < 3; i++) {
        showMoreItems[i].classList.toggle('hidden');
    }

    showMoreItems = document.querySelectorAll('#show-more > .hidden');
    if (showMoreItems.length === 0) {
        showMoreButton.classList.add('hidden');
    }
});