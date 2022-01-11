const ratings = { //평점 값 넣는곳
  project_1: 2.82,
  project_2: 3.30,
  project_3: 1.90,
  project_4: 4.30,
  project_5: 4.20,
  project_6: 3.30,
  project_7: 3.50,
};



// for (const rating in ratings) {
//     const starPercentage = (ratings[rating] / starTotal) * 100;
//     const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;
//     numberRating = document.querySelector(`.${rating} .number`); //총 평점
//     document.querySelector(`.${rating} .stars-inner`).style.width = starPercentageRounded;
//     numberRating.innerText = ratings[rating].toFixed(2) + "/5.00"; //총 평점
// }

//총 별개수
const starTotal = 5;

function star(rating, value) {// rating = 별점 값 , value = 순번 (1부터 시작)
  rating_id = "project_" + value; // 별점 class
  const starPercentage = (rating / starTotal) * 100;
  const starPercentageRounded = `${(Math.round(starPercentage / 10) * 10)}%`;// 별점 채우기
  numberRating = document.querySelector(`#${rating_id} .number`); //총 평점 텍스트 출력
  document.querySelector(`#${rating_id} .stars-inner`).style.width = starPercentageRounded; //칠해지는 별class
  numberRating.innerText = rating.toFixed(2) + "/5.00"; //총 평점 텍스트 출력
}


