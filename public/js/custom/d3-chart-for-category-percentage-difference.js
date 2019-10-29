var dataset = JSON.parse($('#dataset').val());
var json = {
    'children': dataset
}

var data = json.children;
window.totalBubbleDataLength = data.length;
var output = [];
$.each(data, function (index, data) {
    if (data.cheaper === false) {
        output.push("<ul><li><i class='fa fa-square' style='color: #fe4d67;'></i> " + data.name + "</li></ul>");
    } else {
        output.push("<ul><li><i class='fa fa-square' style='color: #00fdaa'></i> " + data.name + "</li></ul>");
    }
});

$("#ulList").html(output.join(""));

var diameter = 900;
var margin = {
    left: 50,
    right: 50,
    top: 0,
    bottom: 0
};

var bubble = d3.pack()
    .size([diameter, diameter])
    .padding(5);

var cheaper = 'cheaper';
var moreExpensive = 'more expensive';
if (envLang === 'de') {
    cheaper = 'günstiger';
    moreExpensive = 'günstiger';
}

var svg = d3.select('#chart').append('svg')
    .attr('viewBox', '0 0 ' + (diameter + margin.right) + ' ' + diameter)
    .attr('width', (diameter + margin.right))
    .attr('height', diameter)
    .attr('class', 'chart-svg');
console.log(svg)

var root = d3.hierarchy(json)
    .sum(function (d) {
        return d.value;
    })
    .sort(function (a, b) {
        return b.value - a.value;
    });

bubble(root);

var node = svg.selectAll('.node')
    .data(root.children)
    .enter()
    .append('g').attr('class', 'node')
    .attr('transform', function (d) {
        return 'translate(' + d.x + ' ' + d.y + ')';
    })
    .append('g').attr('class', 'graph');


node.append("circle")
    .attr("r", function (d, i) {
        return d.r;
    })
    .style("fill", function (d) {
        if (d.data.cheaper === false) {
            return '#fe4d67';
        } else {
            return '#00fdaa'
        }
    });

var tooltip = d3.select("body").append("div")
    .attr("class", "tooltip")
    .style("opacity", 0);

node.on("mouseover", function (d) {
    var string = d.data.name + '\n' + d.data.value + '%';
    var isChaper = d.data.cheaper ? ' ' + cheaper : ' ' + moreExpensive;
    string += isChaper;
    tooltip.transition().duration(200).style("opacity", .9);
    tooltip.html(string)
        .style("left", (d3.event.pageX) + "px")
        .style("top", (d3.event.pageY - 28) + "px");
})
    .on("mouseout", function (d) {
        tooltip.transition().duration(500).style("opacity", 0);
    });

node.append("text")
    .style("text-anchor", "middle")
    .attr('class', 'id')
    .append('svg:tspan')
    .attr('x', 0)
    .attr('dy', 0)
    .text(function (d, i) {
        if (window.totalBubbleDataLength - 3 > i) {
            return d.data.name;
        } else if (window.totalBubbleDataLength - 3 === i) {
            return d.data.name.length > 4 ? d.data.name.substr(0, 5) + '...' : d.data.name;
        }
        return null;
    })
    .append('svg:tspan')
    .attr('x', 0)
    .attr('dy', 15)
    .text(function (d, i) {
        if (window.totalBubbleDataLength - 3 > i) {
            return d.data.value + '%';
        } else if (window.totalBubbleDataLength - 3 === i) {
            let numString = d.data.value.toString();
            return numString.length > 4 ? numString.substr(0, 2) + '...' : d.data.value + '%';
        }
        return null;
    })
    .append('svg:tspan')
    .attr('x', 0)
    .attr('dy', 15)
    .text(function (d, i) {
        if (window.totalBubbleDataLength - 3 > i) {
            return d.data.cheaper === false ? moreExpensive : cheaper;
        }

    })
    .style("fill", "#1a203a");
