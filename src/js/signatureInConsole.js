const signatureInConsole = () => {
    let msg = "%c Fait par hellomarcel.be"; 
	let styles = [ 
		'font-size: 12px', 
		'font-family: monospace', 
		'background: white', 
		'display: inline-block', 
		'color: black', 
		'padding: 8px 19px', 
		'margin: 18px 0', 
		'background: linear-gradient(to right, #f2f2f2, #fff);', 
		'border: 1px solid;' 
	].join(';');
	
    console.log(msg, styles);
}

export default signatureInConsole;