import { __ } from '@wordpress/i18n';

// Components.
import { ToggleControl } from '@wordpress/components';
import { PluginDocumentSettingPanel } from '@wordpress/editor';

// Hooks.
import { usePostMetaValue } from '@alleyinteractive/block-editor-tools';

function EvergreenPost() {
  const [evergreenPost, setEvergreenPost] = usePostMetaValue('evergreen_post');

  return (
    <PluginDocumentSettingPanel
      name="evergreen-post"
      title={__('Evergreen Post', 'wp-evergreen-posts')}
    >
      <ToggleControl
        label={__('Remove date from URL', 'wp-evergreen-posts')}
        onChange={() => setEvergreenPost(!evergreenPost)}
        checked={evergreenPost}
      />
    </PluginDocumentSettingPanel>
  );
}

export default EvergreenPost;
