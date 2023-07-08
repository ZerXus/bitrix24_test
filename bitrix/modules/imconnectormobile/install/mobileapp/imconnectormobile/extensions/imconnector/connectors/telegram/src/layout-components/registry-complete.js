/**
 * @module imconnector/connectors/telegram/layout-components/registry-complete
 */
jn.define('imconnector/connectors/telegram/layout-components/registry-complete', (require, exports, module) => {
	const { Loc } = require('loc');
	function Complete(props = {})
	{
		return View(
			{
				style: {
					flexDirection: 'column',
					paddingTop: 124,
					alignItems: 'center',
					paddingRight: 18,
					paddingLeft: 22,
					backgroundColor: '#FAFDED',
				},
			},
			Image({
				style: {
					height: 96,
					width: 130,
					marginBottom: 10,
				},
				resizeMode: 'center',
				svg: {
					content: '<svg width="118" height="96" viewBox="0 0 118 96" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M84.5912 3.50899C85.3018 3.50899 85.8779 2.93291 85.8779 2.22227C85.8779 1.51163 85.3018 0.935547 84.5912 0.935547C83.8805 0.935547 83.3045 1.51163 83.3045 2.22227C83.3045 2.93291 83.8805 3.50899 84.5912 3.50899ZM21.0977 14.6242C22.6383 14.6242 23.8871 13.3754 23.8871 11.8348C23.8871 10.2942 22.6383 9.04538 21.0977 9.04538C19.5572 9.04538 18.3083 10.2942 18.3083 11.8348C18.3083 13.3754 19.5572 14.6242 21.0977 14.6242ZM21.0977 13.069C21.7793 13.069 22.3319 12.5164 22.3319 11.8348C22.3319 11.1532 21.7793 10.6006 21.0977 10.6006C20.4161 10.6006 19.8636 11.1532 19.8636 11.8348C19.8636 12.5164 20.4161 13.069 21.0977 13.069ZM6.92667 41.8556C9.00159 41.8556 10.6836 40.1736 10.6836 38.0987C10.6836 36.0237 9.00159 34.3417 6.92667 34.3417C4.85176 34.3417 3.1697 36.0237 3.1697 38.0987C3.1697 40.1736 4.85176 41.8556 6.92667 41.8556ZM6.92668 39.8949C7.9187 39.8949 8.72289 39.0907 8.72289 38.0987C8.72289 37.1066 7.9187 36.3024 6.92668 36.3024C5.93466 36.3024 5.13047 37.1066 5.13047 38.0987C5.13047 39.0907 5.93466 39.8949 6.92668 39.8949ZM102.312 89.1296C103.789 89.1296 104.987 87.9321 104.987 86.4548C104.987 84.9776 103.789 83.78 102.312 83.78C100.835 83.78 99.6373 84.9776 99.6373 86.4548C99.6373 87.9321 100.835 89.1296 102.312 89.1296ZM102.312 87.7376C103.021 87.7376 103.595 87.1633 103.595 86.4548C103.595 85.7463 103.021 85.172 102.312 85.172C101.604 85.172 101.029 85.7463 101.029 86.4548C101.029 87.1633 101.604 87.7376 102.312 87.7376ZM59.5003 96C84.9054 96 105.5 75.4051 105.5 50C105.5 24.5949 84.9054 4.00003 59.5003 4.00003C34.0952 4.00003 13.5003 24.5949 13.5003 50C13.5003 75.4051 34.0952 96 59.5003 96ZM13.4783 92.7847H4.53576C4.45924 92.7847 4.38338 92.7818 4.30828 92.776C2.28725 92.7288 0.663188 91.0303 0.663086 88.9421C0.663674 87.9243 1.05766 86.9485 1.75836 86.2292C2.11754 85.8605 2.54222 85.5748 3.00427 85.3839C2.99654 85.2803 2.9926 85.1756 2.9926 85.07C2.99324 83.9961 3.40896 82.9664 4.14832 82.2075C4.88768 81.4486 5.89011 81.0226 6.93508 81.0233C8.27366 81.025 9.45548 81.7129 10.1657 82.7629C10.503 82.64 10.8661 82.5733 11.2443 82.5735C12.9153 82.5756 14.2876 83.8846 14.4467 85.5586C16.0478 85.9173 17.2459 87.3831 17.2445 89.1357C17.2428 91.1554 15.6488 92.7916 13.6835 92.7907C13.6146 92.7907 13.5462 92.7887 13.4783 92.7847ZM108.249 21.6471H114.595C114.643 21.6498 114.692 21.6512 114.741 21.6512C116.135 21.6518 117.267 20.5362 117.268 19.1591C117.269 17.9642 116.418 16.9648 115.282 16.7202C115.169 15.5788 114.195 14.6863 113.01 14.6849C112.741 14.6848 112.483 14.7303 112.244 14.814C111.74 14.0981 110.901 13.6291 109.951 13.6279C109.21 13.6275 108.498 13.9179 107.974 14.4354C107.449 14.9528 107.154 15.6549 107.154 16.3871C107.154 16.4591 107.156 16.5304 107.162 16.601C106.834 16.7312 106.532 16.9261 106.278 17.1774C105.78 17.6678 105.501 18.3332 105.5 19.0272C105.5 20.4509 106.653 21.6089 108.087 21.6412C108.141 21.6451 108.194 21.6471 108.249 21.6471Z" fill="#F1FBD0"/><g filter="url(#filter0_d_1445_224813)"><ellipse cx="59.5006" cy="50.0001" rx="34.8316" ry="34.8316" fill="white"/></g><path fill-rule="evenodd" clip-rule="evenodd" d="M56.518 53.2271L50.62 47.3291L46.4505 51.4986L56.2911 61.3391L56.2951 61.3351L56.522 61.562L74.8267 43.2573L70.6572 39.0878L56.518 53.2271ZM59.5004 76.3344C44.9563 76.3344 33.166 64.544 33.166 49.9999C33.166 35.4558 44.9563 23.6655 59.5004 23.6655C74.0445 23.6655 85.8348 35.4558 85.8348 49.9999C85.8348 64.544 74.0445 76.3344 59.5004 76.3344Z" fill="#9DCF00"/><defs><filter id="filter0_d_1445_224813" x="22.6689" y="14.1685" width="73.6631" height="73.6631" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/><feOffset dy="1"/><feGaussianBlur stdDeviation="1"/><feComposite in2="hardAlpha" operator="out"/><feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0"/><feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1445_224813"/><feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1445_224813" result="shape"/></filter></defs></svg>',
				},
			}),
			Text({
				style: {
					fontSize: 18,
					fontWeight: '400',
					color: '#333333',
					textAlign: 'center',
					marginBottom: 8,
					lineHeightMultiple: 1.2,
				},
				text: Loc.getMessage('IMCONNECTORMOBILE_TELEGRAM_REGISTRY_COMPLETE_TITLE'),
			}),
			Text({
				style: {
					fontSize: 15,
					fontWeight: '400',
					color: '#333333',
					textAlign: 'center',
					lineSpacing: 1.3,
				},
				text: Loc.getMessage('IMCONNECTORMOBILE_TELEGRAM_REGISTRY_COMPLETE_DESCRIPTION'),
			}),

		);
	}

	module.exports = { Complete };
});