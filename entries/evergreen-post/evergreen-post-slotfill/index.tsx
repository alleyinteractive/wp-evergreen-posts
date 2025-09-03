import { __ } from '@wordpress/i18n';

// Components.
import { ToggleControl } from '@wordpress/components';
import { PluginDocumentSettingPanel } from '@wordpress/editor';

// Hooks.
import { usePostMetaValue } from '@alleyinteractive/block-editor-tools';

declare const wpEvergreenPostsConfig: { metaKey: string };

function EvergreenPost() {
  // Get the meta field key from the filter in PHP.
  const metaKey = typeof wpEvergreenPostsConfig !== 'undefined' ? wpEvergreenPostsConfig.metaKey : 'evergreen_post';

  const [evergreenPost, setEvergreenPost] = usePostMetaValue(metaKey);

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
