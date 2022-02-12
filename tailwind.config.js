module.exports = {
	important: true,
	content: [
		"./templates/**/*.{php,html}",
		"./parts/**/*.{php,html}",
		"./*.php"
	],
	theme: {
		extend: {
		},
	},
	plugins: [
    		require('@tailwindcss/typography'),
	],
}
