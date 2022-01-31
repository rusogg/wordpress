import React from 'react';
import { useNavigate } from 'react-router-dom';
import { MegaMenu } from '@brainstormforce/starter-templates-components';
import { setURLParmsValue } from '../../../utils/url-params';
import { useStateValue } from '../../../store/store';
const MegaMenuOptions = require( './mega-menu-content.json' );
import './style.scss';

const SiteBusinessType = () => {
	const [
		{ siteBusinessType, selectedMegaMenu },
		dispatch,
	] = useStateValue();

	const history = useNavigate();
	return (
		<div className="st-mega-menu-filter">
			<MegaMenu
				parent={ siteBusinessType }
				menu={ selectedMegaMenu }
				options={ MegaMenuOptions }
				onClick={ ( event, option, childItem ) => {
					dispatch( {
						type: 'set',
						siteBusinessType: option.ID,
						selectedMegaMenu: childItem.ID,
						siteSearchTerm: childItem.title,
						onMyFavorite: false,
					} );
					const urlParam = setURLParmsValue( 's', childItem.title );
					history( `?${ urlParam }` );
				} }
			/>
		</div>
	);
};

export default SiteBusinessType;
