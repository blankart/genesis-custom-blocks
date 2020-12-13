/**
 * External dependencies
 */
import * as React from 'react';

/**
 * WordPress dependencies
 */
import { useSelect } from '@wordpress/data';
import {
	EditorNotices,
	ErrorBoundary,
	UnsavedChangesWarning,
} from '@wordpress/editor';
import { StrictMode, useEffect, useState } from '@wordpress/element';

/**
 * Internal dependencies
 */
import { BrowserURL, EditorProvider, Header, Main, Side } from './';
import {
	BLOCK_PANEL,
	DEFAULT_LOCATION,
	NO_FIELD_SELECTED,
} from '../constants';
import { getDefaultBlock } from '../helpers';
import { useBlock } from '../hooks';

/**
 * @callback onErrorType Handler for errors.
 * @return {void}
 */

/**
 * @typedef {Object} EditorProps The component props.
 * @property {onErrorType} onError Handler for errors.
 * @property {number} postId The current post ID.
 * @property {string} postType The current post type.
 * @property {Object} settings The editor settings.
 */

/**
 * @typedef {Object} SelectedField A field to change.
 * @property {string} name The name of the field.
 * @property {string} [parent] The name of the field's parent, if any.
 */

/**
 * The editor component.
 *
 * @param {EditorProps} props The component props.
 * @return {React.ReactElement} The editor.
 */
const Editor = ( { onError, postId, postType, settings } ) => {
	const { block, changeBlockName } = useBlock();
	const [ currentLocation, setCurrentLocation ] = useState( DEFAULT_LOCATION );
	const [ isNewField, setIsNewField ] = useState( false );
	const [ panelDisplaying, setPanelDisplaying ] = useState( BLOCK_PANEL );
	const [ selectedField, setSelectedField ] = useState( NO_FIELD_SELECTED );

	const post = useSelect(
		( select ) => select( 'core' ).getEntityRecord( 'postType', postType, postId ),
		[ postId, postType ]
	);
	const isSavingPost = useSelect(
		( select ) => select( 'core/editor' ).isSavingPost()
	);

	useEffect( () => {
		if ( isSavingPost && ! block.name ) {
			const defaultBlock = getDefaultBlock( postId );
			changeBlockName( defaultBlock.name, defaultBlock );
		}
	}, [ block, changeBlockName, isSavingPost, postId ] );

	if ( ! post ) {
		return null;
	}

	return (
		<StrictMode>
			<UnsavedChangesWarning />
			<div className="h-screen flex flex-col items-center text-black">
				<BrowserURL />
				<EditorProvider
					settings={ settings }
					post={ post }
					useSubRegistry={ false }
				>
					<ErrorBoundary onError={ onError }>
						<EditorNotices />
						<Header />
						<div className="flex w-full h-0 flex-grow">
							<Main
								currentLocation={ currentLocation }
								selectedField={ selectedField }
								setCurrentLocation={ setCurrentLocation }
								setIsNewField={ setIsNewField }
								setPanelDisplaying={ setPanelDisplaying }
								setSelectedField={ setSelectedField }
							/>
							<Side
								isNewField={ isNewField }
								panelDisplaying={ panelDisplaying }
								setPanelDisplaying={ setPanelDisplaying }
								selectedField={ selectedField }
								setCurrentLocation={ setCurrentLocation }
								setIsNewField={ setIsNewField }
								setSelectedField={ setSelectedField }
							/>
						</div>
					</ErrorBoundary>
				</EditorProvider>
			</div>
		</StrictMode>
	);
};

export default Editor;
