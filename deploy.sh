docker build -t vkingmaker/birdboard:latest -t vkingmaker/birdboard:$SHA .

docker push vkingmaker/birdboard:latest

docker push vkingmaker/birdboard:$SHA

kubectl apply -f k8s
kubectl set image deployments/birdboard-deployment webserver=vkingmaker/birdboard:$SHA
