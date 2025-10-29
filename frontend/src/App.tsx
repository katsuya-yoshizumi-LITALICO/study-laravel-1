import React, { useEffect, useState } from 'react';
import { Button } from '@/components/ui/button';

type Post = {
  id: number;
  name: string;
  body: string;
  created_at: string;
};

const API_URL = 'http://localhost:8000/api/posts';

function App() {
  const [posts, setPosts] = useState<Post[]>([]);
  const [name, setName] = useState('');
  const [body, setBody] = useState('');
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    fetchPosts();
  }, []);

  const fetchPosts = async () => {
    setLoading(true);
    const res = await fetch(API_URL);
    const data = await res.json();
    setPosts(data);
    setLoading(false);
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    await fetch(API_URL, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name, body }),
      // credentials: 'include' を削除！
    });
    setName('');
    setBody('');
    fetchPosts();
  };

  return (
    <div className="max-w-xl mx-auto p-4">
      <h1 className="text-2xl font-bold mb-4">掲示板SPA</h1>
      <form onSubmit={handleSubmit} className="mb-6 space-y-4">
        <input
          type="text"
          placeholder="名前"
          value={name}
          onChange={(e) => setName(e.target.value)}
          required
          className="w-full border rounded px-3 py-2"
        />
        <textarea
          placeholder="本文"
          value={body}
          onChange={(e) => setBody(e.target.value)}
          required
          className="w-full border rounded px-3 py-2"
          rows={3}
        />
        <Button type="submit">投稿</Button>
      </form>
      <h2 className="text-xl font-semibold mb-2">投稿一覧</h2>
      {loading ? (
        <p>読み込み中...</p>
      ) : (
        posts.map((post) => (
          <div key={post.id} className="border rounded p-3 mb-2">
            <div className="font-bold">{post.name}</div>
            <div>{post.body}</div>
            <div className="text-xs text-gray-500">{post.created_at}</div>
          </div>
        ))
      )}
    </div>
  );
}

export default App;
