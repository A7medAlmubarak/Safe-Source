const autocannon = require('autocannon');

const test = autocannon({
  url: 'http://127.0.0.1:8000/api',
  connections: 20, // Number of concurrent connections
  duration: 30, // Duration in seconds
  requests: [
    {
      method: 'POST',
      path: '/login',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        email: 'test@example.com',
        password: 'password123'
      })
    }
  ]
});

// Print the results to console
autocannon.track(test, { renderProgressBar: true });

// Listen for completion
test.on('done', (results) => {
  console.log('Test completed');
  console.log(results);
});