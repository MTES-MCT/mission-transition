import React, { useState, useEffect } from "react";
import ReactDOM from 'react-dom'
import AidSearchEngineFilters from "./AidSearchEngineFilters";
import AidList from './AidList'
import {fetchAids} from "./Api";

const AidSearchEngine = () => {
    const [selectedEnvironmentalTopicCategory, setSelectedEnvironmentalTopicCategory] = useState("");
    const [selectedEnvironmentalTopicSector, setSelectedEnvironmentalTopicSector] = useState("");
    const [selectedEnvironmentalTopic, setSelectedEnvironmentalTopic] = useState(null);
    const [environmentalTopicCategories, setEnvironmentalTopicCategories] = useState([]);
    const [environmentalTopicSectors, setEnvironmentalTopicSectors] = useState([]);
    const [environmentalTopics, setEnvironmentalTopics] = useState([]);
    const [regions, setRegions] = useState([]);
    const [aidTypes, setAidTypes] = useState([]);
    const [selectedAidTypes, setSelectedAidTypes] = useState([]);
    const [selectedRegion, setSelectedRegion] = useState("");
    const [aids, setAids] = useState([]);
    const [filteredAids, setFilteredAids] = useState([]);
    const [isSearching, setIsSearching] = useState(false);
    const [hasTopicError, setHasTopicError] = useState(false);
    const [hasSearchError, setHasSearchError] = useState(false);
    const [searchValue, setSearchValue] = useState('');
    const [lastSearchHistory, setLastSearchHistory] = useState({})


    const handleSubmit = (e) => {
        e.preventDefault();
        setHasTopicError(selectedEnvironmentalTopicCategory === null && searchValue === '');
        setHasSearchError(searchValue === '' && selectedEnvironmentalTopicCategory === null);

        let categoryToBeFound = selectedEnvironmentalTopicSector === "" ? selectedEnvironmentalTopicCategory : selectedEnvironmentalTopicSector;
        if (categoryToBeFound !== "" || searchValue !== '') {
            fetchAids(categoryToBeFound, aidTypes, selectedRegion, selectedEnvironmentalTopic, searchValue)
                .then(data => {
                    setAids(data);
                    setFilteredAids(data);
                })
            if (searchValue !== '') {
                _paq.push(['trackSiteSearch',
                    // Search keyword searched for
                    searchValue,
                    // Search category selected in your search engine. If you do not need this, set to false
                    false,
                    // Number of results on the Search results page. Zero indicates a 'No Result Search Keyword'. Set to false if you don't know
                    aids.length
                ]);
            }
            setIsSearching(true);
            setLastSearchHistory({
                category: environmentalTopicSectors.concat(environmentalTopicCategories).find(category => category.id === categoryToBeFound),
                aidTypes: aidTypes,
                region: regions.find(region => region.id === selectedRegion)
            })
        }
    };

    return (
        <>
            <AidSearchEngineFilters
                selectedRegion={selectedRegion}
                selectedEnvironmentalTopicCategory={selectedEnvironmentalTopicCategory}
                selectedEnvironmentalTopicSector={selectedEnvironmentalTopicSector}
                setSelectedRegion={setSelectedRegion}
                setSelectedEnvironmentalTopicCategory={setSelectedEnvironmentalTopicCategory}
                setSelectedEnvironmentalTopicSector={setSelectedEnvironmentalTopicSector}
                environmentalTopicCategories={environmentalTopicCategories}
                environmentalTopicSectors={environmentalTopicSectors}
                setEnvironmentalTopicCategories={setEnvironmentalTopicCategories}
                setEnvironmentalTopicSectors={setEnvironmentalTopicSectors}
                setEnvironmentalTopics={setEnvironmentalTopics}
                environmentalTopics={environmentalTopics}
                selectedEnvironmentalTopic={selectedEnvironmentalTopic}
                setSelectedEnvironmentalTopic={setSelectedEnvironmentalTopic}
                regions={regions}
                setRegions={setRegions}
                searchValue={searchValue}
                setSearchValue={setSearchValue}
                setFilteredAids={setFilteredAids}
                handleSubmit={handleSubmit}
            />
            {!isSearching && (
                <div className="bg-light no-results fr-p-12w">
                    <img alt="lancez-vous" className="mt-w100" src="/build/img/search_default.svg" />
                    <div className="text fr-pt-3w">
                        <p className="fr-pb-3w">Veuillez renseigner les informations/champs de recherche afin d’obtenir des résultats.</p>
                    </div>
                </div>
            )}
            {isSearching && filteredAids.length > 0 && (
                <div className="fr-container fr-pt-3w">
                    <nav role="navigation" className="fr-breadcrumb" aria-label="vous êtes ici :">
                        <button className="fr-breadcrumb__button" aria-expanded="false"
                                aria-controls="breadcrumb-1">Voir le fil d’Ariane
                        </button>
                        <div className="fr-collapse" id="breadcrumb-1">
                            <ol className="fr-breadcrumb__list">
                                <li>
                                    <a className="fr-breadcrumb__link" href="/">Accueil</a>
                                </li>
                                <li>
                                    <a className="fr-breadcrumb__link" aria-current="page">Lancer une recherche</a>
                                </li>
                            </ol>
                        </div>
                    </nav>
                    {!selectedRegion && (<>
                        <AidList
                            aids={filteredAids.filter(aid => aid.perimeter === 'NATIONAL')}
                            perimeterName={'au niveau national'}
                            lastSearchHistory={lastSearchHistory}
                        />
                        <AidList
                            aids={filteredAids.filter(aid => aid.perimeter === 'REGIONAL')}
                            perimeterName={'au niveau régional'}
                            lastSearchHistory={lastSearchHistory}
                        />
                    </>)}
                    {selectedRegion && (<>
                        <AidList
                            aids={filteredAids.filter(aid => aid.perimeter === 'REGIONAL')}
                            perimeterName={'au niveau régional'}
                            lastSearchHistory={lastSearchHistory}
                        />
                        <AidList
                            aids={filteredAids.filter(aid => aid.perimeter === 'NATIONAL')}
                            perimeterName={'au niveau national'}
                            lastSearchHistory={lastSearchHistory}
                        />
                    </>)}
                </div>
            )}
            {isSearching && filteredAids.length <= 0 && (
                <div className="bg-light no-results fr-p-12w">
                    <img src="/build/img/no_results.svg" alt="Pas de résultat" />
                    <div className="text fr-pt-3w">
                        <p className="fr-pb-3w">Notre base de données des aides n’est pas encore complète.</p>
                        <p><b>Relancez une recherche avec d’autres critères pour trouver des résultats.</b></p>
                    </div>
                </div>
            )}
        </>
    )
}

export default AidSearchEngine
