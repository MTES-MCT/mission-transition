import React, {useState} from 'react'
import ReactDOM from 'react-dom'
import {fetchEnvrtonmentalTopics} from './Api'
import AsyncSelect from 'react-select/async'


const AidSearchEngineFilters = () => {

    const [loading, setLoading] = useState(false);
    const [environmentalTopics, setEnvironmentalTopics] = useState([]);

    const getData = (inputValue) => {
        return fetchEnvrtonmentalTopics().then(result => {
            setLoading(false);
            result = result.map(topic => ({label: topic.name, value: topic.name}));
            return result.filter(topic => topic.label.toLowerCase().includes(inputValue.toLowerCase()));
        });
    };

    const handleEnvironmentalTopicsChange = (newValue) => {
        setEnvironmentalTopics(newValue)
        console.log(environmentalTopics)
        return newValue
    }

    const MyAsyncSelect = props => {
        return (
          <AsyncSelect
            loadOptions={getData} // function that executes HTTP request and returns array of options
            placeholder={loading ? "Chargement" : "Selectionner..."}
            isDisabled={loading}
            isMulti
            defaultOptions
            cacheOptions
            onInputChange={handleEnvironmentalTopicsChange}
          />
        );
    };

    return (
        <div className="fr-container-fluid bg-dark">
            <form name="search_form" method="get" noValidate="novalidate">
                <div className="fr-grid-row">
                    <div className="fr-col fr-mx-9w fr-my-7w">
                        <label className="fr-label h3 on-dark fr-mb-3w required"
                               htmlFor="search_form_environmentalTopic">Ma thématique par API</label>
                        {/*<select id="search_form_environmentalTopic" name="search_form[environmentalTopic]"*/}
                                {/*required="required" className="fr-select">*/}
                            {/*<option defaultValue="">Choisir une thématique</option>*/}
                            {/*{getEnvironmentalTopicsOptions()}*/}
                        {/*</select>*/}
                        {MyAsyncSelect()}
                        <div className="environmental-action-error">

                        </div>
                    </div>
                    <div className="fr-col fr-mx-9w fr-my-7w">
                        <div><label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_aidType">Mon
                            besoin</label><select id="search_form_aidType" name="search_form[aidType]"
                                                  className="fr-select">
                            <option value="funding" selected="selected">Trouver un financement</option>
                        </select></div>
                    </div>
                    <div className="fr-col fr-mx-9w fr-my-7w">
                        <div><label className="fr-label h3 on-dark fr-mb-3w required" htmlFor="search_form_region">Ma
                            localisation</label><select id="search_form_region" name="search_form[region]"
                                                        required="required" className="fr-select">
                            <option value="" selected="selected">Toute la France</option>
                            <option value="59">Action cœur de ville</option>
                            <option value="79">Adour-Garonne (Bassin hydrographique)</option>
                            <option value="19">Alliance Intermétropolitaine Loire Bretagne</option>
                            <option value="47">Aude (Département)</option>
                            <option value="26">Auvergne-Rhône-Alpes (Région)</option>
                            <option value="32">Aveyron</option>
                            <option value="28">Bourgogne-Franche-Comté (Région)</option>
                            <option value="61">Bretagne</option>
                            <option value="57">Bretagne (Région)</option>
                            <option value="77">CA Seine Normandie Agglomération (EPCI)</option>
                            <option value="53">CC Pays du Mont-Blanc (EPCI)</option>
                            <option value="56">Centre-Val de Loire (Région)</option>
                            <option value="41">Charente (Département)</option>
                            <option value="30">Communes des quartiers prioritaires de la politique de la ville</option>
                            <option value="82">Communes littorales de la Manche et de l'Atlantique</option>
                            <option value="71">Corse</option>
                            <option value="48">Deux-Sèvres (Département)</option>
                            <option value="51">Est Ensemble (EPT)</option>
                            <option value="46">Europe</option>
                            <option value="52">FORET d'ORIENT (Parc naturel régional)</option>
                            <option value="8">France</option>
                            <option value="12">France métropolitaine</option>
                            <option value="18">Franche-Comté</option>
                            <option value="39">GAL Dombes Saône</option>
                            <option value="21">GAL Seine Normande</option>
                            <option value="1">Grand Est (Région)</option>
                            <option value="62">Guadeloupe</option>
                            <option value="44">Guadeloupe (Région)</option>
                            <option value="63">Guyane</option>
                            <option value="40">Haute-Savoie (Département)</option>
                            <option value="64">Hauts-de-France</option>
                            <option value="2">Hauts-de-France (Région)</option>
                            <option value="33">Hérault</option>
                            <option value="3">Île-de-France (Région)</option>
                            <option value="80">Landes (Département)</option>
                            <option value="65">La Réunion</option>
                            <option value="72">Loire-Bretagne (Bassin hydrographique)</option>
                            <option value="78">Loire (Département)</option>
                            <option value="34">Lot</option>
                            <option value="35">Lozere</option>
                            <option value="42">Lozère (Département)</option>
                            <option value="66">Martinique</option>
                            <option value="43">Martinique (Région)</option>
                            <option value="67">Mayotte</option>
                            <option value="76">Nièvre (Département)</option>
                            <option value="27">Normandie (Région)</option>
                            <option value="68">Nouvelle-Aquitaine</option>
                            <option value="22">Nouvelle-Aquitaine (Région)</option>
                            <option value="69">Occitanie</option>
                            <option value="10">Occitanie (Région)</option>
                            <option value="58">Outre-mer</option>
                            <option value="50">Parc naturel régional de Oise - Pays de France (Parc naturel régional)
                            </option>
                            <option value="15">Parc naturel régional des Préalpes d'Azur (Parc naturel régional)
                            </option>
                            <option value="17">Pays de Brocéliande</option>
                            <option value="70">Pays de la Loire</option>
                            <option value="25">Pays de la Loire (Région)</option>
                            <option value="5">PAYS DES CHÂTEAUX</option>
                            <option value="14">Pays des Vallons de Vilaine</option>
                            <option value="29">Pays du Velay</option>
                            <option value="16">PETR Albigeois-Bastides</option>
                            <option value="6">PETR du Grand Beauvaisis</option>
                            <option value="4">PETR du Pays Lauragais</option>
                            <option value="60">PETR du Pays Portes de Gascogne</option>
                            <option value="11">PETR du Pays Sud Toulousain</option>
                            <option value="9">Provence-Alpes-Côte d'Azur (Région)</option>
                            <option value="38">Réseau des Agences d'urbanisme</option>
                            <option value="74">Rhin-Meuse (Bassin hydrographique)</option>
                            <option value="54">Rhône (Département)</option>
                            <option value="75">Rhône-Méditerranée-Corse (Bassin hydrographique)</option>
                            <option value="20">SCOT DU PAYS COMMINGES-PYRENEES</option>
                            <option value="23">SCOT DU PAYS DE PLOERMEL</option>
                            <option value="45">SCOT DU PERCHE D'EURE-ET-LOIR</option>
                            <option value="49">Seine-et-Marne (Département)</option>
                            <option value="73">Seine-Normandie (Bassin hydrographique)</option>
                            <option value="7">Syndicat Mixte Pays Picard - Vallées de l'Oise et de l'Ailette</option>
                            <option value="36">Tarn</option>
                            <option value="24">Tarn (Département)</option>
                            <option value="37">Tarn-et-Garonne</option>
                            <option value="13">Territoire de la Sambre-Avesnois-Thiérache</option>
                            <option value="31">Territoires couverts par une Agence Locale de l'Energie et du Climat
                                (ALEC)
                            </option>
                            <option value="81">Vaucluse (Département)</option>
                            <option value="55">Vendée (Département)</option>
                        </select></div>
                    </div>
                </div>
                <div className="fr-grid-row fr-grid-row--center">
                    <div className="fr-offset-6">
                        <button type="submit" className="fr-btn fr-btn--secondary cta-search">
                            AFFICHER LES RÉSULTATS
                        </button>
                    </div>
                </div>
                <input type="hidden" id="search_form_regionalLimit" name="search_form[regionalLimit]" value="6" />
                <input type="hidden" id="search_form_nationalLimit" name="search_form[nationalLimit]" value="6" />
            </form>
        </div>
    )
}

export default AidSearchEngineFilters
