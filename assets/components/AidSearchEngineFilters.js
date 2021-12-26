import React, {useState, useEffect} from 'react'
import { fetchEnvironmentalTopicCategories, fetchAidTypes, fetchRegions } from "./Api";

const AidSearchEngineFilters = (
    {
        selectedRegion,
        setSelectedRegion,
        selectedEnvironmentalTopicCategory,
        setSelectedEnvironmentalTopicCategory,
        selectedEnvironmentalTopicSector,
        setSelectedEnvironmentalTopicSector,
        environmentalTopicCategories,
        setEnvironmentalTopicCategories,
        environmentalTopicSectors,
        setEnvironmentalTopicSectors,
        selectedEnvironmentalTopic,
        setSelectedEnvironmentalTopic,
        environmentalTopics,
        setEnvironmentalTopics,
        regions,
        setRegions,
        handleSubmit,
        searchValue,
        setSearchValue,
        setFilteredAids
    }) => {

    let params = new URLSearchParams(window.location.search);

    useEffect(async() => {
        setRegions(await fetchRegions())
        const responseCategories = await fetchEnvironmentalTopicCategories();
        setEnvironmentalTopicSectors(responseCategories.filter(category => category.name.startsWith('Secteur')))
        setEnvironmentalTopicCategories(responseCategories.filter(category => !category.name.startsWith('Secteur')))
        if (params.has('region')) {
            setSelectedRegion(parseInt(params.get('region')))
        }
        if (params.has('sector')) {
            setSelectedEnvironmentalTopicSector(parseInt(params.get('sector')))
            // setEnvironmentalTopics(environmentalTopicSectors.find(sector => sector.id === params.get('sector')).environmentalTopics);
        }
        if (params.has('topic')) {
            setSelectedEnvironmentalTopicCategory(parseInt(params.get('topic')))
        }
    }, [])

    useEffect(() => {
        if (environmentalTopics.length === 0 && selectedEnvironmentalTopicCategory !== "" && environmentalTopicCategories.length > 0) {
            setEnvironmentalTopics(environmentalTopicCategories.find(category => category.id === parseInt(params.get('topic'))).environmentalTopics);
        }
    })

    //GETTERS
    const getRegions = () => {
        return regions.map(region => <option
            selected={parseInt(params.get('region')) === region.id}
            key={region.id}
            value={region.id}>{region.name}
        </option>)
    }

    const getCategories = () => {
        return environmentalTopicCategories.map(category => <option
            selected={parseInt(params.get('topic')) === category.id}
            key={category.id}
            value={category.id}>{category.name}
        </option>)
    }

    const getSectors = () => {
        return environmentalTopicSectors.map(category => <option
            selected={parseInt(params.get('sector')) === category.id}
            key={category.id}
            value={category.id}>{category.name}
        </option>)
    }

    const getTopics = () => {
        return environmentalTopics.map(topic => {
            const isSelected = selectedEnvironmentalTopic === topic.id;
            return (
                <div className="fr-col-2 fr-mr-2w">
                    <div key={topic.id} className={`fr-tile fr-enlarge-link ${isSelected ? 'selected':''}`}>
                        <div className="fr-tile__body">
                            <h4 className="fr-tile__title">
                                <a data-topic={topic.id} className="fr-tile__link" href="" onClick={onTopicClick}>{topic.name}</a>
                            </h4>
                        </div>
                    </div>
                </div>
            )
        })
    }

    //HANDLERS
    const handleRegionsChange = (e) => {
        setSelectedRegion(e.target.value)
    }

    const handleCategoryChange = (e) => {
        setSelectedEnvironmentalTopicCategory(e.target.value)
        setSelectedEnvironmentalTopicSector("")
        setEnvironmentalTopics(environmentalTopicCategories.find(category => category.id === parseInt(e.target.value)).environmentalTopics);
        setSelectedEnvironmentalTopic(null);
    }

    const handleSectorChange = (e) => {
        setSelectedEnvironmentalTopicSector(e.target.value)
        setSelectedEnvironmentalTopicCategory("")
        setEnvironmentalTopics(environmentalTopicSectors.find(category => category.id === parseInt(e.target.value)).environmentalTopics);
        setSelectedEnvironmentalTopic(null);
    }

    const onTopicClick = (e) => {
        e.preventDefault();
        if (parseInt(e.target.dataset.topic) === selectedEnvironmentalTopic) {
            setSelectedEnvironmentalTopic(null);
            return;
        }
        setSelectedEnvironmentalTopic(parseInt(e.target.dataset.topic))
    }

    const handleSearchInput = (e) => {
        setSearchValue(e.target.value)
    }

    const onSearchTabClick = () => {
        setEnvironmentalTopics([])
        setSelectedEnvironmentalTopic(null)
        setSelectedEnvironmentalTopicCategory("")
        setSelectedEnvironmentalTopicSector("")
        setSelectedRegion("")
        setFilteredAids([])
    }

    const onCategoryTabClick = () => {
        setSearchValue("")
        setFilteredAids([])
    }

    let isSubmitButtonDisabled = selectedRegion === "" || (selectedEnvironmentalTopicSector === "" && selectedEnvironmentalTopicCategory === "")

    return (
        <>
            <div className="fr-tabs">
                <ul className="fr-tabs__list" role="tablist" aria-label="Mode de recherche">
                    <li role="presentation">
                        <button onClick={onCategoryTabClick} id="tabpanel-404" className="fr-tabs__tab fr-fi-checkbox-line fr-tabs__tab--icon-left"
                                tabIndex="0" role="tab" aria-selected="true" aria-controls="tabpanel-404-panel">Par thème /
                            secteur
                        </button>
                    </li>
                    <li role="presentation">
                        <button onClick={onSearchTabClick} id="tabpanel-405" className="fr-tabs__tab fr-fi-checkbox-line fr-tabs__tab--icon-left"
                                tabIndex="-1" role="tab" aria-selected="false" aria-controls="tabpanel-405-panel">Par mots
                            clés
                        </button>
                    </li>
                </ul>
                <div id="tabpanel-404-panel" className="fr-tabs__panel fr-tabs__panel--selected" role="tabpanel"
                     aria-labelledby="tabpanel-404" tabIndex="0">
                    <div className="fr-grid-row">
                        <div className="col-12 col-sm-3">
                            <label className="fr-label fr-text--lead" htmlFor="select-region">
                                Je suis situé<span className="mandatory">*</span> en :
                            </label>
                        </div>
                        <div className="col-12 col-sm-6 fr-ml-2w">
                            <select value={selectedRegion} onChange={handleRegionsChange} className="fr-select" id="select-region" name="select-region">
                                <option hidden value="">Selectionnez une localisation</option>
                                {getRegions()}
                            </select>
                        </div>
                    </div>
                    <div className="fr-grid-row">
                        <div className="col-12 col-sm-3">
                            <label className="fr-label fr-text--lead" htmlFor="select-category">
                                Ma thématique<span className="mandatory">*</span> :
                            </label>
                        </div>
                        <div className="col-12 col-sm-6 fr-ml-2w">
                            <select value={selectedEnvironmentalTopicCategory} onChange={handleCategoryChange} className="fr-select" id="select-category" name="select-category">
                                <option hidden value="">Selectionnez une thématique</option>
                                {getCategories()}
                            </select>
                        </div>
                        <div className="col-12 col-sm-3">
                            <label className="fr-label fr-text--lead" htmlFor="select-sector">
                                &nbsp;ou mon secteur<span className="mandatory">*</span> :
                            </label>
                        </div>
                        <div className="col-12 col-sm-6 fr-ml-2w">
                            <select value={selectedEnvironmentalTopicSector} onChange={handleSectorChange} className="fr-select" id="select-sector" name="select-sector">
                                <option value="">Selectionnez un secteur</option>
                                {getSectors()}
                            </select>
                        </div>
                    </div>
                    <hr/>
                    {environmentalTopics.length > 0 && <div className="fr-grid-row">
                        <div className="fr-col-12">
                            <label className="fr-label fr-text--lead" htmlFor="select-category">
                                Mon projet concerne plus précisément :
                            </label>
                        </div>
                        {getTopics()}
                    </div>}
                    <div className="fr-grid-row fr-grid-row--right">
                        <button disabled={isSubmitButtonDisabled} onClick={handleSubmit} className="fr-btn fr-fi-arrow-right-line fr-btn--icon-right fr-btn--secondary">
                            Lancer ma recherche
                        </button>
                    </div>
                </div>
                <div id="tabpanel-405-panel" className="fr-tabs__panel" role="tabpanel" aria-labelledby="tabpanel-405"
                     tabIndex="0">
                    <div className="fr-grid-row">
                        <div className="fr-col-12 fr-col-sm-5">
                            <p className="fr-label fr-text--lead">
                                Je lance une recherche par mot clé<span className="mandatory">*</span> :
                            </p>
                        </div>
                        <div className="fr-col-12 fr-col-sm-7">
                            <div className="fr-search-bar fr-search-bar--lg" id="search-2" role="search">
                                <label className="fr-label" htmlFor="search-input">
                                    Rechercher un mot, une expression, une référence...
                                </label>
                                <input className="fr-input" placeholder="Rechercher un mot, une expression, une référence..." type="search" id="search-input"
                                       name="search-input" value={searchValue} onChange={handleSearchInput}/>
                                    <button onClick={handleSubmit} className="fr-btn">
                                        Rechercher
                                    </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default AidSearchEngineFilters
