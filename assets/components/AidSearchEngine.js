import React, { useState } from "react";
import ReactDOM from 'react-dom'
import AidSearchEngineFilters from "./AidSearchEngineFilters";

const AidSearchEngine = () => {
    const [environmentalTopics, setEnvironmentalTopics] = useState([]);
    const [aidTypes, setAidTypes] = useState([]);
    const [regions, setRegions] = useState([]);
    const [aids, setAids] = useState([]);
    const [noSearchYet, setNoSearchYet] = useState(true);

    const handleSubmit = (e) => {
        e.preventDefault();
        console.log('hello world')
    };

    return (
        <>
            <AidSearchEngineFilters
                setEnvironmentalTopics={setEnvironmentalTopics}
                setAidTypes={setAidTypes}
                setRegions={setRegions}
                handleSubmit={handleSubmit}
            />
            {noSearchYet && (
                <div className="bg-light no-results fr-p-12w">
                    <img alt="lancez-vous" className="mt-w100" src="/build/img/search_default.svg" />
                    <div className="text fr-pt-3w">
                        <p className="fr-pb-3w">Veuillez sélectionner un objectif dans les filtres
                            afin d’avoir des résultats de recherche.
                        </p>
                    </div>
                </div>
            )}
            {!noSearchYet && !aids.length && (
                <div className="bg-light no-results fr-p-12w">
                    <img src="/build/img/no_results.svg" alt="Pas de résultat" />
                        <div className="text fr-pt-3w">
                            <p className="fr-pb-3w">Notre base de données des aides n’est pas encore complète.</p>
                            <p><b>Relancez une recherche avec d’autres critères pour trouver des résultats.</b></p>
                        </div>
                </div>
            )}
            {!noSearchYet && aids.length && (
                <div className="bg-light">
                    <div className="fr-container fr-pt-12w">
                        <p className="subtitle">{aids.length} dispositif(s) correspondent à votre recherche</p>
                    </div>
                </div>
            )}
        </>
    )
}

export default AidSearchEngine
