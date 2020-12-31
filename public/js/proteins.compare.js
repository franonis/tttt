/*
* 依赖于jQuery, echars.min.js, bootstrap
*
*/

var DEFAULT_VALUE = 'No data available!';
var C_LABLE_CLASS = '';
var H_LABLE_CLASS = 'label-warning';
var E_LABLE_CLASS = 'label-primary';
var COIL_LABEL_CLASS = 'label-info';
var LOW_COMPLEXITY_LABEL_CLASS = 'label-primary';
var PEST_LABEL_CLASS = 'label-danger';
var INTRACELLULAR_LABEL_CLASS = '';
var EXTRACELLULAR_LABEL_CLASS = 'label-info';
var TRANSMEMBRANE_HELIX_LABEL_CLASS = 'label-warning';
var DISORDER_LABEL_CLASS= 'label-danger';
var NG_LABEL_CLASS = 'label-danger';
var OG_LABEL_CLASS = 'label-danger';
var length;


/*
 *  渲染整个页面
 */
function renderPage(features, proteins){
	var count = 0;
	for (i in proteins){
		count ++;
	}

	// render pc_feature_checker
	renderFeatureChecker(features);
	
	if(count == 1){
		$('#pca_title').text('Features of alternative Isoform');
		var name; // 蛋白质名称
		for(i in proteins){
			name = i;
		}
		console.log(name);
		renderOneProtein(features, name, proteins[name]);
	} else {
		$('#pca_title').text('Compare Proteins');
		//console.log(proteins);
		renderMulProteins(features, proteins, count);
	}
}



/*
 *  渲染只有一个Protein的页面
 */
function renderFeatureChecker(features) {
	// body...
}

/*
 *  渲染多个proteins的页面
 */
function renderMulProteins(features, proteins, count) {
	$('#pca_title').text('Features of alternative Isoforms');

	var col = count == 2 ? 'col-md-6' : 'col-md-4';

	var new_row_flag = 0;
	var i = 0;
	for(name in proteins){
		i++;
		new_row_flag ++;
		new_row = (new_row_flag % 3 == 0) ? true : false;
		renderOneProtein(features, name, proteins[name], col, new_row);
		 if(i % 3 == 0 && i){
		 	$('#pca').append('<div class="col-md-12"><hr></div>');
		 }
	}
}

/*
 *  渲染只有一个Protein的页面
 */
function renderOneProtein(features, name, protein, col='col-md-12', new_row=false) {
	pdom_id = name.replace(/\./g,'_');

	//console.log(pdom_id);
	$('#pca').append('<div class="'+col+'" id="'+ pdom_id +'"></div>');
	$('#'+ pdom_id).append('<h3 class="protein_title">'+ name + '<small> <-- Download all the features</small><a '+ 'href="download/features/'+name+'"'+'><i class="layui-icon" style="font-size: 25px;" >  &#xe601;</i></a>'+'</h3>');
	renderGotoGene(pdom_id, name);
	renderPercentPerProtein(pdom_id, getFeatureValue('percent_per_protein', features, protein) , features);

	renderSimpleFeature(pdom_id, features, protein, name);
	

	// renderSequenceLength(pdom_id, getFeatureValue('sequence_length', features, protein), name);
	// renderMolecularWeight(pdom_id, getFeatureValue('molecular_weight', features, protein));
	// renderGravy(pdom_id, getFeatureValue('gravy', features, protein));
	// renderCharge(pdom_id, getFeatureValue('charge', features, protein));
	// renderMolarExtinctionCoefficient(pdom_id, getFeatureValue('molar_extinction_coefficient', features, protein));
	//renderIsoElectricPoint(pdom_id, getFeatureValue('iso_electric_point', features, protein));
	//renderAliphaticIndex(pdom_id, getFeatureValue('aliphatic_index', features, protein));

	renderSecondaryStructure(pdom_id, getFeatureValue('secondary_structure', features, protein), protein.sequence);
	renderCoil(pdom_id, getFeatureValue('coil', features, protein), protein.sequence);
	renderLowComplexity(pdom_id, getFeatureValue('low_complexity', features, protein), protein.sequence);
	renderPEST(pdom_id, getFeatureValue('PEST', features, protein), protein.sequence);
	renderTransmembrane(pdom_id, getFeatureValue('transmember', features, protein), protein.sequence);
	renderDisorder(pdom_id, getFeatureValue('disorder', features, protein), protein.sequence);
	renderProsite(pdom_id, getFeatureValue('prosite', features, protein));
	renderPrositeGraph(pdom_id, getFeatureValue('prosite', features, protein));
	renderPfam(pdom_id, getFeatureValue('pfam', features, protein));
	renderPfamGraph(pdom_id, getFeatureValue('pfam', features, protein));
	//renderProteinFunction(pdom_id, getFeatureValue('protein_function', features, protein));
	//renderKEGG(pdom_id, getFeatureValue('kegg', features, protein));
	renderSignalp(pdom_id, getFeatureValue('signalp', features, protein), features);
	renderLocation(pdom_id, getFeatureValue('location', features, protein));
	renderNetphos(pdom_id, getFeatureValue('netphos', features, protein));
	renderOGlycosylation(pdom_id, getFeatureValue('O_Glycosylation', features, protein), protein.sequence);
	renderNGlycosylation(pdom_id, getFeatureValue('N_Glycosylation', features, protein), protein.sequence);
}

function renderGotoGene(pdom_id, name) {
	genename = name.replace('P','G');
	genename = genename.replace(/AS\.\d+/,'');
	//console.log(genename);
	$('#'+ pdom_id).append('<br><br><h3 class="text-center">Gene Information</h3><br><br><div id="gene" class="text-center" class="panel-body"><a href="http://cmb.bnu.edu.cn/alt_iso/index.php/search/gene/'+genename+'" style="color:deepskyblue">'+genename+'</a></div>');
}

function renderSimpleFeature(pdom_id, features, protein, name) {
	length = getFeatureValue('sequence_length', features, protein); length = length ? length : DEFAULT_VALUE;
	var molecular_weight = getFeatureValue('molecular_weight', features, protein); molecular_weight = molecular_weight ? molecular_weight  : DEFAULT_VALUE;
	var gravy = getFeatureValue('gravy', features, protein); gravy = gravy ? gravy.substr(0, gravy.indexOf(".") + 4) : DEFAULT_VALUE;
	var charge = getFeatureValue('charge', features, protein); charge = charge ? charge.substr(0, charge.indexOf(".") + 4) : DEFAULT_VALUE;
	var mec = getFeatureValue('molar_extinction_coefficient', features, protein); mec = mec ? mec.substr(0, mec.indexOf(".") + 4) : DEFAULT_VALUE;
	var aindex = getFeatureValue('aliphatic_index', features, protein); aindex = aindex ? aindex.substr(0, aindex.indexOf(".") + 4) : DEFAULT_VALUE;
	var iepoint = getFeatureValue('iso_electric_point', features, protein); iepoint = iepoint ? iepoint.substr(0, iepoint.indexOf(".") + 4) : DEFAULT_VALUE;
	molecular_weight = formatData(molecular_weight);
	length = formatData(length);
	aindex = formatData(aindex);
	mec = formatData(mec);
	gravy = returnFloat(gravy);
	charge = returnFloat(charge);
	iepoint = returnFloat(iepoint);

	var rows = '<tr><td width="50%">Length</td><td width="50%">' + length + '</td></tr>';
	rows += '<tr><td width="50%">Molecular Weight</td><td width="50%">' + molecular_weight + '</td></tr>';
	rows += '<tr><td width="50%">Gravy</td><td width="50%">' + gravy + '</td></tr>';
	rows += '<tr><td width="50%">Charge</td><td width="50%">' + charge + '</td></tr>';
	rows += '<tr><td width="50%">Molar Extinction Coefficient</td><td width="50%">' + mec + '</td></tr>';
	rows += '<tr><td width="50%">Aliphatic Index</td><td width="50%">' + aindex + '</td></tr>';
	rows += '<tr><td width="50%">Iso Electric Point</td><td width="50%">' + iepoint + '</td></tr>';

	var table = '<br><div id="' + pdom_id + '_sequence_feature" class="netphos" ><h3 class="text-center">Sequence Features</h3><h4 class="text-center">Data source : <a href = "http://www.gravy-calculator.de">GRAVY CALCULATOR &</a><a href = "http://emboss.open-bio.org"> EMBOSS</a></h4><br><table class="table table-hover"><thead><tr><th>Features</th><th>Value</th></tr></thead><tbody>'+rows+'</tbody></table></div>';
	$('#'+pdom_id).append(table);
}

/*
 *	渲染单个特征
 */

function renderPercentPerProtein(pdom_id, value, features) {
	var feature_name = 'percent_per_protein';
	var amino_acids  = getFeatureInfo(feature_name, features); amino_acids = amino_acids['comment'].split('-');

	if(value === null){
		$('#'+pdom_id).append('<div id="' + pdom_id + '_percent_per_protein" class="text-center percent_per_protein"><h3>Amino Acid Percentage</h3><p class="feature-value">'+DEFAULT_VALUE+'</p></div>');
		return;
	}

	value = value.split('-');
	feature_name = feature_name.replace(/\_/, ' ').toUpperCase();
	//console.log(pdom_id);

	$('#'+ pdom_id).append('<br><br><h3 class="text-center">Amino Acid Percentage</h3><div id="' + feature_name + '_' + pdom_id + '" class="percent_per_protein"></div>');
	
	var data = [];
	for(i in amino_acids){
		data.push({value: value[i], name: amino_acids[i]})
	}

	var percent_per_protein_chart = echarts.init(document.getElementById(feature_name + '_' + pdom_id));
	var option = {
	    title : {
	        text: '',
	        x: 'center'
	    },
	    tooltip : {
	        trigger: 'item',
	        formatter: "{b}: {d}%"
	    },
	    
	    series : [
	        {
	            name: 'Amino Acid Percentage',
	            type: 'pie',
	            radius : '68%',
	            center: ['50%', '60%'],
	            data: data,
	            itemStyle: {
	                emphasis: {
	                    shadowBlur: 10,
	                    shadowOffsetX: 0,
	                    shadowColor: 'rgba(0, 0, 0, 0.5)'
	                }
	            }
	        }
	    ]
	};

	percent_per_protein_chart.setOption(option);
}
function renderSequenceLength(pdom_id, length, name) {
	if(length === null) {
		length = DEFAULT_VALUE;
		$('#'+pdom_id).append('<div id="' + pdom_id + '_sequence_length" class="text-center sequence-length"><h4>Protein Length</h4><div class="feature-value">'+ length+' </div></div>');
	}
	$('#'+pdom_id).append(
		'<div id="' + pdom_id + '_sequence_length" class="text-center sequence-length">'+
		'<h4>Protein Length</h4><div class="feature-value">'+length+
		' bp <a class="button button-tiny" href="/protein/'+ name +'/sequence/download"><i class="fa fa-download"></i> FASTA</a></div>' +
		'</div>'
	);
}
function renderMolecularWeight(pdom_id, weight) {
	if(weight === null) {weight = DEFAULT_VALUE;}
	$('#'+pdom_id).append('<div id="' + pdom_id + '_molecular_weight" class="text-center molecular-weight"><h4>Molecular Weight</h4><div class="feature-value">'+ weight+' </div></div>');
}
function renderGravy(pdom_id, gravy) {
	if(gravy === null) {gravy = DEFAULT_VALUE;}
	gravy = gravy.substr(0, gravy.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_gravy" class="text-center gravy"><h4>Gravy</h4><div class="feature-value">'+ gravy +' </div></div>');
}
function renderCharge(pdom_id, charge) {
	if(charge === null) {charge = DEFAULT_VALUE;}
	charge = charge.substr(0, charge.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_charge+" class="text-center charge"><h4>Charge</h4><div class="feature-value">'+ charge +' </div></div>');
}

function renderMolarExtinctionCoefficient(pdom_id, mec) {
	if(mec === null) {mec = DEFAULT_VALUE;}
	mec = mec.substr(0, mec.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_molar_extinction_coefficient" class="text-center mec"><h4>Molar Extinction Coefficient</h4><div class="feature-value">'+ mec +' </div></div>');
}

function renderIsoElectricPoint(pdom_id, iep) {
	if(iep === null) {iep = DEFAULT_VALUE;}
	iep = iep.substr(0, iep.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_iso_electric_point" class="text-center iep"><h4>Iso Electric Point</h4><div class="feature-value">'+ iep +' </div></div>');
}

function renderAliphaticIndex(pdom_id, ai) {
	if(ai === null) {ai = DEFAULT_VALUE;}
	ai = ai.substr(0, ai.indexOf(".") + 4);  // 保留小数后3位
	$('#'+pdom_id).append('<div id="' + pdom_id + '_aliphatic_index" class="text-center ai"><h4>Aliphatic Index</h4><div class="feature-value">'+ ai +' </div></div>');
}


function renderSecondaryStructure(pdom_id, ss, seq) {
	if(ss === null) {
		ss = DEFAULT_VALUE;
	} else {
		var html = '';
		html += '<p class="text-left">';
		ss = ss.split(';');
		var count = 0;
		for(i in ss){
			var loc = ss[i].split('-');
			var type, start, len;
			if(loc[0] == 'C'){type = C_LABLE_CLASS;} 
			else if(loc[0] == 'H'){type = H_LABLE_CLASS;}
			else {type = E_LABLE_CLASS;}
			start = parseInt(loc[1]) - 1;
			end = parseInt(loc[2]) - start;
			var subseq = seq.substr(start, end);
			for(j in subseq){
				count++;
				html += '<label class="'+ type +'" title="Position: '+count+'" id = "secondarystructure'+pdom_id+count+'">' + subseq[j] + '</label>';
			}
		}
		html += '</p>';
		ss = html;
	}
	var legend = '<p>Legend: <label class="'+H_LABLE_CLASS+'">Helix</label> <label class="' + E_LABLE_CLASS + '">Sheet</label> <label class="' + C_LABLE_CLASS + '">Coiled</label></p>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_secondary_structure" class="text-center secondary-structure"><h3>Secondary Structure</h3>Data source : <a href = "http://bioinfadmin.cs.ucl.ac.uk/downloads/psipred/">PSIPRED</a><br><br>'+legend+'<div class="feature-value">'+ ss +' </div></div>');
	for (var i = 0; i <= count; i++) {
		$('#secondarystructure'+pdom_id+i).poshytip();
	}
}

function renderCoil(pdom_id, coil, seq) {
	if(coil === null) {
		coil = DEFAULT_VALUE;
	} else {
		var html = '<p class="text-left">';
		coils = coil.split(';');
		var locus = [];
		for(var i in coils){
			locus = locus.concat(parseInterval(coils[i]));
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				var j =parseInt(i) +1;
				html += '<label class="'+ COIL_LABEL_CLASS +'" title="Position: '+j+'" id = "coil'+pdom_id+i+'">' + seq[i] + '</label>';
			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}

		coil = html + '</p>';
	}
	// C/E/H - start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_coil" class="text-center coil"><h3>Coiled Coils</h3>Data source : <a href = "http://emboss.open-bio.org">EMBOSS</a><br><br><br><div class="feature-value">'+ coil +' </div></div>');
	for(var i in seq){
		$('#coil'+pdom_id+i).poshytip();
	}
}

function renderLowComplexity(pdom_id, lc, seq) {
	if(lc === null) {lc = DEFAULT_VALUE;}
	else {
		var html = '<p class="text-left">';
		lc = lc.split(';');
		var locus = [];
		for(var i in lc){
			locus = locus.concat(parseInterval(lc[i]));
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				var j =parseInt(i) +1;
				html += '<label class="'+ LOW_COMPLEXITY_LABEL_CLASS +'" title="Position: '+j+'" id = "lowcomplexity'+pdom_id+i+'">' + seq[i] + '</label>';
			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}

		lc = html + '</p>';
	}

	$('#'+pdom_id).append('<div id="' + pdom_id + '_low_complexity+' + '" class="text-center lc"><h3>Low Complexity Regions</h3>Data source : <a href = "http://emboss.open-bio.org">EMBOSS</a><br><br><div class="feature-value">'+ lc  +'</div></div>');
	for (var i in seq) {
		$('#lowcomplexity'+pdom_id+i).poshytip();
	}
}

function renderPEST(pdom_id, pest, seq) {
	if(pest === null) {pest = DEFAULT_VALUE;}
	else {
		var html = '<p class="text-left">';
		pest = pest.split(';');
		var locus = [];
		for(var i in pest){
			locus = locus.concat(parseInterval(pest[i]));
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				var j =parseInt(i) +1;
				html += '<label class="'+ PEST_LABEL_CLASS +'" title="Position: '+j+'" id = "pest'+pdom_id+i+'">' + seq[i] + '</label>';
			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}

		pest = html + '</p>';
	}
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_pest+' + '" class="text-center pest"><h3>PEST regions</h3>Data source : <a href = "http://emboss.open-bio.org">EMBOSS</a><br><br><div class="feature-value">'+ pest  +' </div></div>');
	for (var i in seq) {
		$('#pest'+pdom_id+i).poshytip();
	}
}


function renderTransmembrane(pdom_id, transmembrane, seq) {
	if(transmembrane === null) {transmembrane = DEFAULT_VALUE;}
	else {
		var html = '';
		var count = 0;
		html += '<p class="text-left">';
		ts = transmembrane.split(';');
		for(i in ts){
			var loc = ts[i].split('-');
			var type, start, len;
			if(loc[0].match(/intra/i)){type = INTRACELLULAR_LABEL_CLASS;} 
			else if(loc[0].match(/trans/i)){type = TRANSMEMBRANE_HELIX_LABEL_CLASS;}
			else {type = EXTRACELLULAR_LABEL_CLASS;}
			start = parseInt(loc[1]) - 1;
			end = parseInt(loc[2]) - start;
			var subseq = seq.substr(start, end);
			for(j in subseq){
				count++
				html += '<label class="'+ type +'"title="Position: '+count+'" id = "transmembrane'+pdom_id+count+'">' + subseq[j] + '</label>';
			}
		}
		html += '</p>';
		transmembrane = html;
	}

	var legend = '<p>Legend: <label class="'+ INTRACELLULAR_LABEL_CLASS +
				'">Intracellular</label> <label class="' + TRANSMEMBRANE_HELIX_LABEL_CLASS + 
				'">Transmembrane Helix</label> <label class="' + EXTRACELLULAR_LABEL_CLASS + 
				'">Extracellular</label></p>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_transmembrane+' + '" class="text-center transmembrane"><h3>Transmembrane Segments</h3>Data source : <a href = "http://bioinfadmin.cs.ucl.ac.uk/downloads/memsat/">MEMSAT</a><br><br>' + legend + '<div class="feature-value">'+ transmembrane  +' </div></div>');
	for (var i = 0; i <= count; i++) {
			$('#transmembrane'+pdom_id+i).poshytip();
		}
}

function renderDisorder(pdom_id, disorder, seq) {
	if(disorder === null) {disorder = DEFAULT_VALUE;}
	else {
		var html = '<p class="text-left">';
		disorder = disorder.split(';');
		var locus = [];
		for(var i in disorder){
			locus = locus.concat(parseInterval(disorder[i]));
			
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				var j = parseInt(i)+1;
				html += '<label class="label-danger" title="Position: '+j+'" id = "disorder'+pdom_id+i+'">' + seq[i] + '</label>';
				

			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}
		
		
		disorder = html + '</p>';
	}
	
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_disorder+' + '" class="text-center disorder"><h3>Intrinsically Disordered Regions</h3>Data source : <a href = "http://bioinfadmin.cs.ucl.ac.uk/downloads/DISOPRED/">DISOPRED</a><br><br><div class="feature-value">'+ disorder  +' </div></div>');
	for (var i in seq) {
		$('#disorder'+pdom_id+i).poshytip();
	}
}


function renderProsite(pdom_id, prosite) {
	var rows = '';
	if(prosite === null) {rows = '<tr><td colspan=4>No data available!</td></tr>';}
	else {
		prosite = prosite.split(';');
		for(var i in prosite){
			p = prosite[i].split('~');
			rows += '<tr><td class="text-left">'+p[0]+'</td><td class="text-left">'+p[1]+'</td><td class="text-left">'+p[2]+'</td><td class="text-left">'+p[3]+'</td></tr>';
		}
	}

	// prosite id, motif, start, end
	var table_head = '<table class="table table-hover"><thead><tr><th>Prosite ID</th><th>Motif</th><th>Start</th><th>End</th></thead>'
	var table_body = '<tbody>' + rows + '</tbody>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_prosite+' + '" class="text-center pfam" style="height:250px;"><h3 >Motifs</h3>Data source : <a href = "https://www.ebi.ac.uk/interpro/download.html">InterProScan</a><br><br><div class="feature-value">'+table_head + table_body +' </table></div></div>');
}

function renderPrositeGraph(pdom_id, prosite) {
	var feature_name = 'prosite_graph';
	var color =['#7b9ce1','#bd6d6c','#75d874','#e0bc78','#dc77dc','#72b362','#7b9ce1','#bd6d6c','#75d874','#e0bc78','#dc77dc','#72b362','#7b9ce1','#bd6d6c','#75d874','#e0bc78','#dc77dc','#72b362'];
	var motif = [];
	var starts = [];
	var ends = [];
	var id=[];
	var uniqmotifcolor = [];
	var uniqmotif = [];	
	var durations = [];
	var dataCount = 0;
	if(prosite === null){
		$('#'+pdom_id).append('<div id="' + pdom_id + '_prosite_graph" class="pfam_graph" style="height:150px;"></div>');
		return;
	}
	else{
		prosites = prosite.split(';');
		dataCount = prosites.length;
		for (var i in prosites) {
			p = prosites[i].split('~');
			var leng = p[3]-p[2]+1;
			motif.push(p[1]);
			starts.push(p[2]);
			ends.push(p[3]);
			id.push(p[0]);
			durations.push(leng);	
		}
	var j = 0;
		for (var i in id) {
			if (uniqmotif.indexOf(id[i]) == -1) {
				uniqmotifcolor[id[i]]=color[j];
				uniqmotif.push(id[i]);
	    		j++;
			}
		}
		
	}
	$('#'+ pdom_id).append('<div id="' + feature_name + '_' + pdom_id + '" class="pfam_graph" style="height:150px;"></div>');
	var motifgraph = echarts.init(document.getElementById(feature_name + '_' + pdom_id));
	var data = [];
	var startTime = 0;
	var ca = ['motif'];
	echarts.util.each(ca, function (category, index) {
	    for (var i = 0; i < dataCount; i++) {
	        data.push({
	            name: motif[i],
	            value: [
	                index,
	                starts[i],
	                ends[i],
	                durations[i],
	                id[i],
	                motif[i],
	            ],
	            itemStyle: {
	                normal: {
	                    color: uniqmotifcolor[id[i]]
	                }
	            }
	        });
	    }
	});

	//console.log(data);
	function renderItem(params, api) {
	    var categoryIndex = api.value(0);
	    var start = api.coord([api.value(1), categoryIndex]);
	    var end = api.coord([api.value(2), categoryIndex]);
	    var height = api.size([0, 1])[1] * 0.4;
	    var rectShape = echarts.graphic.clipRectByRect({
	        x: start[0],
	        y: start[1] - height,
	        width: end[0] - start[0],
	        height: height*2
	    }, {
	        x: params.coordSys.x,
	        y: params.coordSys.y,
	        width: params.coordSys.width,
	        height: params.coordSys.height
	    });
	    return rectShape && {
	        type: 'rect',
	        shape: rectShape,
	        style: api.style()
	    };
	    
	}
	option = {
	    tooltip: {
	        formatter: function (params) {
	        	var line = '';
	            line = "<ur style='text-align:left'><li style=\"color: blue;\">Prosite ID:&ensp;&ensp;&ensp;&ensp;&ensp;"+params.value[4]+"</li>";
	            line +="<li>Motif:&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;" + params.value[5] + "</li>";
	            line +="<li>Coordinates:&ensp;&ensp;&ensp;"+params.value[1]+"-" + params.value[2] + "</li>";
	            line +="<li>Source:&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;InterProScan</li></ur>";
	            return line;
	        },
	        backgroundColor: 'rgba(245, 245, 245, 0.8)',
	        textStyle: {
                color: '#000'
            }
	    },
	    grid: {
	        height:25
	    },
	    xAxis: {
	        min: startTime,
	        splitLine:{show: true},
	        title:'length of the protein',
	        max: length,
	        scale:true
	    },
	    yAxis: {
	    	show: true,
	    	scale:true,
	        data: ca
	    },
	    series: [{
	        type: 'custom',
	        name: 'something',
	        renderItem: renderItem,
	        barWidth:50,
	        itemStyle: {
	            normal: {
	                opacity: 0.8
	            }
	        },
	        encode: {
	            x: [1, 2],
	            y: 0
	        },
	        data: data
	    }]
	};
	motifgraph.setOption(option);
}

function renderPfam(pdom_id, pfam) {
	var rows = '';
	if(pfam === null) {rows = '<tr><td colspan=4>No data available!</td></tr>';}

	else {
		pfam = pfam.split(';');
		for(var i in pfam){
			p = pfam[i].split('~');
			domainname = p[3].split('+');
			rows += '<tr><td class="text-left">'+p[2]+'</td><td class="text-left">'+domainname[0]+'</td><td class="text-left">'+p[0]+'</td><td class="text-left">'+p[1]+'</td><td class="text-left">'+p[4]+'</td></tr>';
		}
	}

	// start   end     no_pfam domain_name     p-value
	var table_head = '<br><table class="table table-hover"><thead><tr><th>Pfam ID</th><th>Domain</th><th>Start</th><th>End</th><th>e-value</th></thead>'
	var table_body = '<tbody>' + rows + '</tbody>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_pfam+' + '" class="text-center pfam" style="height:250px;"><h3 >Domains</h3>Data source : <a href = "https://www.ebi.ac.uk/interpro/download.html">InterProScan</a><br><br><div class="feature-value">'+table_head + table_body +' </table></div></div>');
}

function renderPfamGraph(pdom_id, pfam) {
	var feature_name = 'pfam_graph';
	var color =['#7b9ce1','#bd6d6c','#75d874','#e0bc78','#dc77dc','#72b362','#7b9ce1','#bd6d6c','#75d874','#e0bc78','#dc77dc','#72b362','#7b9ce1','#bd6d6c','#75d874','#e0bc78','#dc77dc','#72b362'];
	var categories = [];
	var domain = [];
	var description = [];
	var starts = [];
	var ends = [];
	var id=[];
	var durations = [];
	var dataCount = 0;
	var uniqdomian=[];
	var uniqdomiancolor=[];

	if(pfam === null){
		$('#'+pdom_id).append('<div id="' + pdom_id + '_pfam_graph" class="pfam_graph" style="height:150px;"></div>');
		return;
	}
	else{
		
		
		pfams = pfam.split(';');
		dataCount = pfams.length;
		for (var i in pfams) {
			p = pfams[i].split('~');
			var leng = p[1]-p[0]+1;
			categories.push(p[3]);
			starts.push(p[0]);
			ends.push(p[1]);
			id.push(p[2]);
			durations.push(leng);	
		}
		var j = 0;
		for (var i in categories) {
			depart = categories[i].split('+');
			domain[i] = depart[0];
			description[i] = depart[1];
			if (uniqdomian.indexOf(categories[i]) == -1) {
				uniqdomiancolor[categories[i]]=color[j];
				uniqdomian.push(categories[i]);
	    		j++;
			}
		}
	}

 
	$('#'+ pdom_id).append('<div id="' + feature_name + '_' + pdom_id + '" class="pfam_graph" style="height:150px;"></div>');

	var domaingraph = echarts.init(document.getElementById(feature_name + '_' + pdom_id));
	var data = [];
	var startTime = 0;
	var ca = ['domain'];

	// true data
	echarts.util.each(ca, function (category, index) {
	    for (var i = 0; i < dataCount; i++) {
	        data.push({
	            name: categories[i],
	            value: [
	                index,
	                starts[i],
	                ends[i],
	                durations[i],
	                id[i],
	                domain[i],
	                description[i]
	            ],
	            itemStyle: {
	                normal: {
	                    color: uniqdomiancolor[categories[i]]
	                }
	            }
	        });
	    }
	});
	
	
	
	function renderItem(params, api) {
	    var categoryIndex = api.value(0);
	    var start = api.coord([api.value(1), categoryIndex]);
	    var end = api.coord([api.value(2), categoryIndex]);
	    var height = api.size([0, 1])[1] * 0.4;
	   
	
	    var rectShape = echarts.graphic.clipRectByRect({
	        x: start[0],
	        y: start[1] - height,
	        width: end[0] - start[0],
	        height: height*2
	    }, {
	        x: params.coordSys.x,
	        y: params.coordSys.y,
	        width: params.coordSys.width,
	        height: params.coordSys.height
	    });
	
	    return rectShape && {
	        type: 'rect',
	        shape: rectShape,
	        style: api.style()
	    };
	}
	
	
	option = {
	    tooltip: {
	        formatter: function (params) {
	        	var line = '';
	            line = "<ur style='text-align:left'><li style=\"color: blue;\">Pfam ID:&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;"+params.value[5]+"("+params.value[4]+")"+"</li>";
	            line +="<li>Description:&ensp;&ensp;&ensp;&ensp;" + params.value[6] + "</li>";
	            line +="<li>Coordinates:&ensp;&ensp;&ensp;"+params.value[1]+"-" + params.value[2] + "</li>";
	            line +="<li>Source:&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;InterProScan</li></ur>";
	            return line;
	        },
	        backgroundColor: 'rgba(245, 245, 245, 0.8)',
	        textStyle: {
                color: '#000'
            }
	    },
	    grid: {
	        height:25
	    },
	    xAxis: {
	        min: startTime,
	        splitLine:{show: false},
	        title:'length of the protein',
	        max: length,
	        scale:false
	    },
	    yAxis: {
	    	show: false,
	    	scale:false,
	        data: ca
	    },
	    series: [{
	        type: 'custom',
	        name: 'something',
	        renderItem: renderItem,
	        barWidth:50,
	        itemStyle: {
	            normal: {
	                opacity: 0.8
	            }
	        },
	        encode: {
	            x: [1, 2],
	            y: 0
	        },
	        data: data
	    }]
	};

	domaingraph.setOption(option);
}

function renderProteinFunction(pdom_id, pf) {
	var rows = '';
	if(pf === null) {rows = '<tr><td colspan=4>No data available!</td></tr>';}
	else {
		pf = pf.split(';');
		for(var i in pf){
			p = pf[i].split('~');
			go = p.shift();
			asp = p.shift();
			desc = p.join(' ');
			rows += '<tr><td>'+ go +'</td><td>'+ asp +'</td><td class="text-left">'+ desc +'</td></tr>';
		}
	}

	var table_head = '<table class="table table-hover"><thead><tr><th>GO ID</th><th>Aspect</th><th>Protein Function</th></thead>'
	var table_body = '<tbody>' + rows + '</tbody>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_protein_function" class="protein-function"><h3 >Protein Function</h3>Data source : <a href = "http://bioinfadmin.cs.ucl.ac.uk/downloads/psipred/">PSIPRED</a><br><br><div class="feature-value">'+table_head + table_body +' </table></div></div>');
}

function renderKEGG(pdom_id, kegg) {
	var rows = '';
	if(kegg === null) {rows = '<tr><td colspan=4>No data available!</td></tr>';}
	else {
		kegg = kegg.split(';');
		for(var i in kegg){
			p = kegg[i].split('~');
			id = p.shift();
			desc = p.join(' ');
			rows += '<tr><td>'+ id +'</td><td class="text-left">'+ desc +'</td></tr>';
		}
	}
	var table_head = '<table class="table table-hover"><thead><tr><th>ID</th><th>Pathway</th></thead>'
	var table_body = '<tbody>' + rows + '</tbody>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_kegg" class="kegg"><h3 >KEGG</h3>Data source : <a href = "http://bioinfadmin.cs.ucl.ac.uk/downloads/psipred/">PSIPRED</a><br><br><div class="feature-value">'+table_head + table_body +' </table></div></div>');
}

function renderSignalp(pdom_id, signalp) {
	var signalp1 = signalp - 1;

	if(signalp === null) {signalp = "no signal peptide";}else{signalp = "Cleavage site between postion : "+signalp1+ " and " + signalp}
	
	// start - end
	$('#'+pdom_id).append('<div id="' + pdom_id + '_signalp+' + '" class="text-center signalp"><h3 >Signal Peptides</h3>Data source : <a href = "http://www.cbs.dtu.dk/services/SignalP/">Signalp</a><br><br><div class="feature-value text-center">'+ signalp +'</div></div><br><br><br>');
}


function renderLocation(pdom_id, location) {
	var feature_name = 'location';

	if(location === null){
		$('#'+pdom_id).append('<div id="' + pdom_id + '_location" class="text-center location"><h3 >Subcellular Localization</h3>Data source : <a href = "http://genome.unmc.edu/ngLOC/">ngLOC</a><br><br><p class="feature-value">'+DEFAULT_VALUE+'</p></div>');
		return;
	}


	$('#'+ pdom_id).append('<div id="' + pdom_id + '_location" class="text-center location"><h3 >Subcellular Localization</h3>Data source : <a href = "http://genome.unmc.edu/ngLOC/">ngLOC</a><br><div id="' + feature_name + '_' + pdom_id + '" class="location"></div></div><br><br><br><br>');

	location = location.split('-');

	location = [
		{name: 'Cytoplasm', value: location[0]},
		{name: 'Cytoskeleton', value: location[1]},
		{name: 'Endoplasmic Reticulum', value: location[2]},
		{name: 'Extracellular/Secreted', value: location[3]},
		{name: 'Golgi Apparatus', value: location[4]},
		{name: 'Mitochondria', value: location[5]},
		{name: 'Nuclear', value: location[6]},
		{name: 'Plasma Membrane', value: location[7]},
		{name: 'Peroxisome', value: location[8]},
		{name: 'Chloroplast', value: location[9]},
		{name: 'Vacuole', value: location[10]}
	];
	
	var location_chart = echarts.init(document.getElementById(feature_name + '_' + pdom_id));
	var option = {
	    title : {
	        text: 'Location Probability Distribution',
	        textStyle:{
	        	fontWeight:'normal',
	        	fontSize:14
	        },
	        x: 'center'
	    },
	    tooltip : {
	        trigger: 'item',
	        formatter: "{b} : {d}%"
	    },
	    
	    series : [
	        {
	            name: 'Location Probability Distribution',
	            type: 'pie',
	            radius : '68%',
	            center: ['50%', '60%'],
	            data: location,
	            itemStyle: {
	                emphasis: {
	                    shadowBlur: 10,
	                    shadowOffsetX: 0,
	                    shadowColor: 'rgba(0, 0, 0, 0.5)'
	                }
	            }
	        }
	    ]
	};

	location_chart.setOption(option);
}


function renderNetphos(pdom_id, netphos) {
	var rows = '';
	if(netphos === null) {rows = '<tr><td colspan=2>No data available!</td></tr>';}
	else {
		netphos = netphos.split(';');
		netph = [];
		for(var i in netphos){
			p = netphos[i].split('-');
			loc = p[0];
			tmp = p.shift();
			type = p.join(' ').replace(/~/g, ' / ');
			netph[loc] = type;
		}
		for (var i in netph) {
			rows += '<tr><td class="text-left" width="50%">'+ i +'</td><td class="text-left" width="50%">'+ netph[i] +'</td></tr>';	
		}
	}

	var table_head = '<table class="table table-hover"><thead><tr><th>Position</th><th>Phosphorylation types</th></thead>'
	var table_body = '<tbody>' + rows + '</tbody>';
	$('#'+pdom_id).append('<div id="' + pdom_id + '_netphos" class="text-center netphos"><h3 >Phosphorylation Sites</h3>Data source : <a href = "http://www.cbs.dtu.dk/services/NetPhos/">NetPhos</a><br><br><div class="feature-value">'+table_head + table_body +' </table></div></div><br>');
}

function renderOGlycosylation(pdom_id, og, seq) {
	if(og === null) {og = DEFAULT_VALUE;}
	else {
		
		var html = '<p class="text-left">';
		og = og.split(';');
		var locus = [];
		for(var n in og){
			locus.push(parseInt(og[n]));
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				var j =parseInt(i) +1;
				html += '<label class="'+ OG_LABEL_CLASS +'" title="Position: '+j+'" id = "oglycosylation'+pdom_id+i+'">' + seq[i] + '</label>';
			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}

		og = html + '</p>';
	}

	// "site-type"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_O_Glycosylation" class="text-center O-Glycosylation"><h3>O-GalNAc glycosylation sites</h3>Data source : <a href = "http://www.cbs.dtu.dk/services/NetOGlyc/">NetOglyc</a><br><br><div class="feature-value">'+ og  +'</div></div><br>');
	for (var i in seq) {
		$('#oglycosylation'+pdom_id+i).poshytip();
	}
}



function renderNGlycosylation(pdom_id, ng, seq) {
	if(ng === null) {ng = DEFAULT_VALUE;}
	else {
		
		var html = '<p class="text-left">';
		ng = ng.split(';');
		var locus = [];
		for(var n in ng){
			locus.push(parseInt(ng[n]));
		}

		for(var i in seq){
			if(arrayContains(locus, parseInt(i)+1)){
				var j =parseInt(i) +1;
				html += '<label class="'+ NG_LABEL_CLASS +'" title="Position: '+j+'" id = "nglycosylation'+pdom_id+i+'">' + seq[i] + '</label>';
			} else {
				html += '<label>' + seq[i] + '</label>';
			}
		}

		ng = html + '</p>';
	}

	// "site-type"
	$('#'+pdom_id).append('<div id="' + pdom_id + '_N_Glycosylation" class="text-center N-Glycosylation"><h3>N-linked glycosylation sites</h3>Data source : <a href = "http://www.cbs.dtu.dk/services/NetNGlyc/">NetNGlyc</a><br><br><div class="feature-value">'+ ng  +'</div></div><br>');
	for (var i in seq) {
		$('#nglycosylation'+pdom_id+i).poshytip();
	}
}



/**
 * 数组是否包含某个值
 * @param  string interval 区间字符串，如‘73-89’
 * @return array          
 */
function arrayContains(arr, obj) {
	var i = arr.length;
	while (i--) {
		if (arr[i] == parseInt(obj)) {
			return true;
		}
	}
	return false;
}



/**
 * 解析区间为数组
 * @param  string interval 区间字符串，如‘73-89’
 * @return array          
 */
function parseInterval(interval) {
	if(interval.indexOf('-') == -1){
		return [];
	}
	interval = interval.split('-');
	min = parseInt(interval[0]);
	max = parseInt(interval[1]);
	var arr = [];
	for(var i = min; i <= max; i++){
		arr.push(i);
	}
	return arr;
}


/**
 * 计算一个数值是否属于某个区间
 * 
 * @param  {[int]} needle   判断的数值
 * @param  {[string]} interval 区间:min-max 如2-3
 * @return {[boolean]}          
 */
function between(needle, interval) {
	if(interval.indexOf('-') == -1){
		return false;
	}
	needle = parseInt(needle);
	interval = interval.split('-');
	min = parseInt(interval[0]);
	max = parseInt(interval[1]);

	return needle >= min && needle <= max;
}


// 获取某个特征的值，name=特征名称  features=特征列表 protein=单个蛋白的数据
function getFeatureValue(name, features, values) {
	feature_idx = getFeatureIndex(name, features);
	return feature_idx === null ? null : (values[feature_idx] ? values[feature_idx] : null);
}

function getFeatureInfo(name, features) {
	for(i in features){
		if(features[i].name == name){
			return features[i];
		}
	}
	return null;
}


function getFeatureIndex(name, features) {
	var feature_idx = null;
	for(i in features){
		if(features[i].name == name){ feature_idx = i; break;}
	}
	return feature_idx;
}

function formatData(num) {
	num += '';
	if (!num.includes('.')) num += '.';
	return num.replace(/(\d)(?=(\d{3})+\.)/g, function($0, $1) {
	  return $1 + ',';
	}).replace(/\.$/, '');
}

function returnFloat(value){
 var value=Math.round(parseFloat(value)*100)/100;
 var xsd=value.toString().split(".");
 if(xsd.length==1){
 value=value.toString()+".00";
 return value;
 }
 if(xsd.length>1){
 if(xsd[1].length<2){
 value=value.toString()+"0";
 }
 return value;
 }
}
