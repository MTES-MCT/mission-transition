import React from 'react'
import ReactDOM from 'react-dom'
import AidSearchEngineFilters from "./AidSearchEngineFilters";

const AidSearchEngine = ({filters}) => {
    console.log(filters);
    return (
        <AidSearchEngineFilters />
    )
}

export default AidSearchEngine
