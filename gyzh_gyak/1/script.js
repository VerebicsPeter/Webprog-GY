const numbers = [5, 2, 15, -3, 6, -8, -2];

const matrix = [
   [1, 0, 3],
   [0, 2, 0],
   [4, 5, 6],
   [0, 0, 0],
]

const searchResults = {
   "Search": [
     {
       "Title": "The Hobbit: An Unexpected Journey",
       "Year": "2012",
       "imdbID": "tt0903624",
       "Type": "movie"
     },
     {
       "Title": "The Hobbit: The Desolation of Smaug",
       "Year": "2013",
       "imdbID": "tt1170358",
       "Type": "movie"
     },
     {
       "Title": "The Hobbit: The Battle of the Five Armies",
       "Year": "2014",
       "imdbID": "tt2310332",
       "Type": "movie"
     },
     {
       "Title": "The Hobbit",
       "Year": "1977",
       "imdbID": "tt0077687",
       "Type": "movie"
     },
     {
       "Title": "Lego the Hobbit: The Video Game",
       "Year": "2014",
       "imdbID": "tt3584562",
       "Type": "game"
     },
     {
       "Title": "The Hobbit",
       "Year": "1966",
       "imdbID": "tt1686804",
       "Type": "movie"
     },
     {
       "Title": "The Hobbit",
       "Year": "2003",
       "imdbID": "tt0395578",
       "Type": "game"
     },
     {
       "Title": "A Day in the Life of a Hobbit",
       "Year": "2002",
       "imdbID": "tt0473467",
       "Type": "movie"
     },
     {
       "Title": "The Hobbit: An Unexpected Journey - The Company of Thorin",
       "Year": "2013",
       "imdbID": "tt3345514",
       "Type": "movie"
     },
     {
       "Title": "The Hobbit: The Swedolation of Smaug",
       "Year": "2014",
       "imdbID": "tt4171362",
       "Type": "movie"
     }
   ],
   "totalResults": "51",
   "Response": "True"
}

 // a - numbers minden elemehez negyzetetet irni:
console.log('a) feladat')
numbers.forEach(x => console.log(x * x))

 // b - min of numbers
console.log('b) feladat')
console.log(Math.min(...numbers))

 // c - has row of zero
console.log('c) feladat')
function firstRowOfNulls (input_matrix) {
    let ind = -1
    for (let i = 0; i < input_matrix.length && ind === -1; i++) {
      if (input_matrix[i].every(x => x === 0)) ind = i
    }
    return ind
}
console.log(firstRowOfNulls(matrix))

// d - filter movies
console.log('d) feladat')
let filtered = searchResults['Search'].filter(x => x['Year'] > 2010 && x['Type'] === 'movie')
for (const f of filtered) {
    console.log(f['imdbID'])
}
