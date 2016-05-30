<script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Everyman\Neo4j\Client;
use Everyman\Neo4j\Index\NodeIndex;
$client = new Client('localhost', 7474);
$client->getTransport()->setAuth('neo4j', '123456');
//$keanu = $client->makeNode()->setProperty('name', 'Marin Ion')->save();
// $myfirstnodeID = $keanu->getId();
//echo $myfirstnodeID;
//$master_user=$client->getNode($myfirstnodeID);
////var_dump($master_user);
//$actors = new NodeIndex($client, 'Actor');
//$actors->add($keanu, 'name', $keanu->getProperty('name'));
//echo 'Node form';
?>


<div id="status">
</div>

<div id='result'></div>

<?php
//$client = new Client('tsartsaris.gr', 7474);
$queryString = "START n=node(216) ".
    "MATCH (n)-[:FOLLOW]->(x:Employee)".
    "RETURN n,x";
$query = new Everyman\Neo4j\Cypher\Query($client, $queryString);
$result = $query->getResultSet();
//var_dump($result);
$fbnodes=$links=  array();
$i = 0;
foreach ($result as $row) {  //iterate the result set
    $node_name=$row['x']->getProperty('firstname'); //get node name
    $node_image=$row['x']->getProperty('lastname');  //get node profile image url
    $node_url=$row['x']->getProperty('position'); //get node profile link url
    $single_node['firstname']=$node_name;  //put them in the array
    $single_node['lastname']=$node_image;
    $single_node['login']=$node_url;
    $single_node['group']=1;  //same group as root node
    array_push($fbnodes,$single_node); //add the array to $fbnodes
    $single_link['source']=$i; //the source node from the counter
    $single_link['target']=0; //pointing back to the root node
    $single_link['value']=10+$i;  //trick to make the visualization a little bit more interesting, play with this a bit yourself
    $i=$i+1;  //increase the counter by one to be used for the next node
    array_push($links,$single_link);  //put the single link array to the links array
}
$dataset['nodes']=$fbnodes;  //putting the nodes array in the dataset with key value "nodes"
$dataset['links']=$links;  //putting the links array in the dataset with key value of "links"
$json = json_encode($dataset, JSON_PRETTY_PRINT); //create the json file, to use the pretty print you have to use version>php5.4
$json =  str_replace('\\/', '/',$json); //make it readable for the links
$json =  str_replace(' ', '',$json); //remove spaces, this is critical or else the d3.js library will not be able to read the links, I don't know why.
$fp = fopen('results.json', 'w');
fwrite($fp, $json);
fclose($fp); //save the json file.
?>

    <!DOCTYPE html>
    <meta charset="utf-8">
    <!--<script src="http://d3js.org/d3.v3.min.js"></script>-->
    <!--<script src="js/glow.js"></script>-->
    <style>

    .link {
      stroke: #ccc;
    }

    .node text {
      pointer-events: none;
      font: 10px sans-serif;
    }

    </style>
    <body>
    <script>
    var width = 1680,
        height = 1020

    var svg = d3.select("body").append("svg")
        .attr("width", width)
        .attr("height", height);

    var force = d3.layout.force()
        .gravity(.1)
        .distance(150)
        .charge(-500)
        .size([width, height]);

    d3.json("http://dev.neo.com/results.json", function(json) {   //load the json file
      force
          .nodes(json.nodes)
          .links(json.links)
          .start();

    d3.select("body").transition()
        .style("background-color", "grey");

      var link = svg.selectAll(".link")
          .data(json.links)
        .enter().append("line")
          .attr("class", "link");

      var node = svg.selectAll(".node")
          .data(json.nodes)
        .enter().append("g")
          .attr("class", "node")
          .call(force.drag);    //in order to work the on click function on the image think of it like giving a href to a img tag in pure html.

    node.append("image:a")   //we append images to the nodes
      .attr("xlink:href", function(d){return d.url;})  //giving profile links on click
      .append("image")
          .attr("xlink:href", function(d) { return d.imgurl; })  //retrieving the images from image links
          .attr("x", -8)
          .attr("y", -8)
          .attr("width", 34)
          .attr("height", 34);

      node.append("text")  //make friends name visible
          .attr("dx", 18)
          .attr("dy", ".35em")
          .attr("fill", "#fff")
          .text(function(d) { return d.firstname + ' ' + d.lastname }); //get the names from the json file

      force.on("tick", function() {
        link.attr("x1", function(d) { return d.source.x; })
            .attr("y1", function(d) { return d.source.y; })
            .attr("x2", function(d) { return d.target.x; })
            .attr("y2", function(d) { return d.target.y; });

        node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
      });
    });
    </script>