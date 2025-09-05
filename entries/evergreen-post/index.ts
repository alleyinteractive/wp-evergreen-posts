/**
 * Entry for evergreen-post slotfill.
 *
 * Register slotfills in child folders under the current directory and import
 * them here.
 */
import { registerPlugin } from '@wordpress/plugins';
import EvergreenPost from './evergreen-post-slotfill';

registerPlugin('wp-evergreen-posts-evergreen-post', {
  render: EvergreenPost,
  icon: 'admin-post',
});
