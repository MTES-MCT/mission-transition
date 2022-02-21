import React from 'react';

const Aid = ({ aid, last = false }) => {
    const getLowerAndUpperBound = () => {
        if (!aid.subventionRateLowerBound && !aid.subventionRateUpperBound) {
            return;
        }

        return (
            <div className="aid-type fr-mb-1w">
                <span className="mt-icon-circled mt-icon-circled--inline mt-icon-circled--blue-bg">
                    <span className="mt-icon mt-icon--euro mt-icon--color-white" />
                </span>
                <span className="subtitle color-navy">
                    {aid.subventionRateLowerBound !== null && 'min : ' + aid.subventionRateLowerBound + '%'}
                    {aid.subventionRateLowerBound !== null && aid.subventionRateUpperBound !== null && ' / '}
                    {aid.subventionRateUpperBound !== null && 'max : ' + aid.subventionRateUpperBound + '%'}
                </span>
            </div>
        );
    };

    const getApplicationDates = () => {
        if (!aid.applicationStartDate && !aid.applicationEndDate) {
            return;
        }
        const applicationStartDate = new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium' }).format(
            new Date(aid.applicationStartDate)
        );
        const applicationEndDate = new Intl.DateTimeFormat('fr-FR', { dateStyle: 'medium' }).format(
            new Date(aid.applicationEndDate)
        );

        if (!applicationEndDate) {
            return (
                <div className="aid-dates fr-mb-1w">
                    <span className="mt-icon-circled mt-icon-circled--inline">
                        <span className="mt-icon mt-icon--time" />
                    </span>
                    <span className="subtitle">Dispositif temporaire, disponible depuis le {applicationStartDate}</span>
                </div>
            );
        }

        return (
            <div className="aid-dates fr-mb-1w">
                <span className="mt-icon-circled mt-icon-circled--inline">
                    <span className="mt-icon mt-icon--time" />
                </span>
                <span className="subtitle">
                    Dispositif temporaire, du {applicationStartDate} au {applicationEndDate}
                </span>
            </div>
        );
    };

    const getRegions = () => {
        const getSeparator = (index) => {
            if (aid.regions.length === 1 || index === aid.regions.length - 1) {
                return '';
            }

            return ', ';
        };

        return (
            <div className="aid-regions fr-mb-1w">
                <span className="mt-icon-circled mt-icon-circled--inline">
                    <span className="mt-icon mt-icon--finger-up" />
                </span>
                <span className="subtitle">
                    {aid.regions.map((region, index) => (
                        <span>{region.name + getSeparator(index)}</span>
                    ))}
                </span>
            </div>
        );
    };

    const getTypes = () => {
        const getSeparator = (index) => {
            if (aid.fundingTypes.length === 1 || index === aid.fundingTypes.length - 1) {
                return '';
            }

            return ', ';
        };

        return (
            <div className="aid-type fr-mb-1w">
                <span className="mt-icon-circled mt-icon-circled--inline">
                    <span className="mt-icon mt-icon--euro" />
                </span>
                <span className="subtitle">
                    {aid.fundingTypes.map((type, index) => (
                        <span>{type + getSeparator(index)}</span>
                    ))}
                </span>
            </div>
        );
    };

    return (
        <div className="fr-card fr-enlarge-link bg-beige" id={last ? 'last-regional-aid' : ''}>
            <div className="fr-card__body">
                <h4 className="fr-card__title">
                    <a
                        target="_blank"
                        href={aid.directAccess ? aid.fundingSourceUrl : '/dispositif/' + aid.slug}
                        className="fr-card__link">
                        {aid.name}
                    </a>
                </h4>
                <div className="funder fr-mb-1w">
                    <span className="mt-icon-circled mt-icon-circled--inline">
                        <span className="mt-icon mt-icon--building" />
                    </span>
                    <span className="subtitle">{aid.funder.name}</span>
                </div>
                {getApplicationDates()}
                {getLowerAndUpperBound()}
                {getTypes()}
                {getRegions()}
            </div>
        </div>
    );
};

export default Aid;
