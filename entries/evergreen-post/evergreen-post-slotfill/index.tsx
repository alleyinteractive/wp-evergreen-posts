import { __ } from '@wordpress/i18n';

// Components.
import { ToggleControl } from '@wordpress/components';
import { PluginDocumentSettingPanel } from '@wordpress/editor';

// Hooks.
import { usePostMetaValue } from '@alleyinteractive/block-editor-tools';

function EvergreenPost() {
  const [evergreenUrl, setEvergreenUrl] = usePostMetaValue('evergreen_url');

  return (
    <PluginDocumentSettingPanel
      name="evergreen-url"
      title={__('Evergreen URL', 'wp-evergreen-posts')}
    >
      <ToggleControl
        label={__('Remove date from URL', 'wp-evergreen-posts')}
        onChange={() => setEvergreenUrl(!evergreenUrl)}
        checked={evergreenUrl}
      />
    </PluginDocumentSettingPanel>
  );
}

export default EvergreenPost;
